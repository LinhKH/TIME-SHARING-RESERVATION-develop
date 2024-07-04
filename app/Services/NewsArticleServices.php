<?php

namespace App\Services;

use App\Services\CommonConstants;
use App\Services\ApiServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\NewsArticleEav\NewsArticleEavRepository;
use App\Repositories\NewsArticle\NewsArticleRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class NewsArticleServices
{
    protected NewsArticleRepository $newArticle;
    protected NewsArticleEavRepository $newArticleEav;
    protected ApiServices $apiServices;

    public function __construct(
        NewsArticleRepository    $newArticle,
        NewsArticleEavRepository $newArticleEav,
        ApiServices              $apiServices
    )
    {
        $this->newArticle = $newArticle;
        $this->newArticleEav = $newArticleEav;
        $this->apiServices = $apiServices;
    }

    public function getListNews(): array
    {
        try {
            $dataResult = null;
            $listNews = $this->newArticle->paginate(CommonConstant::PER_PAGE);
            if (empty($listNews['data'])) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => $dataResult
                ];
            }
            foreach ($listNews['data'] as $key => $item) {
                $tmpEav = null;
                $tmpEav = $this->convertDataNewsEav($this->newArticleEav->findManyBy('namespace', $item['id'])->toArray());
                $dataResult['data'][] = array_merge($item, $tmpEav);
            }
            $dataResult['pagination'] = $this->apiServices->getPaginate($listNews);
            return $dataResult;
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function CreateNews($dataInput): array
    {
        if (empty($dataInput)) {
            return [
                "status" => CommonConstant::ERROR_CODE,
                "msg" => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
        try {
            DB::beginTransaction();
            $newsArticle = [
                'active' => $dataInput['active'],
                'creationTime' => $dataInput['creationTime'] ?? 1
            ];
            $resultCreateNews = $this->newArticle->create($newsArticle);
            if (!empty($dataInput['attribute'])) {
                foreach ($dataInput['attribute'] as $key => $item) {
                    $dataNewEav = null;
                    if (empty($item)) {
                        continue;
                    }
                    $dataNewEav = [
                        'attribute' => $key,
                        'namespace' => $resultCreateNews->id,
                        'type' => CommonConstant::STATUS_ACTIVE,
                        'value' => $item
                    ];
                    $this->newArticleEav->create($dataNewEav);
                }
            }
            DB::commit();
            return ['news_id' => $resultCreateNews->id, 'msg' => CommonConstant::MSG_SUCCESSFUL];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function updateNews($newsId, $dataInput): array
    {
        if (empty($dataInput)) {
            return [
                "status" => CommonConstant::ERROR_CODE,
                "msg" => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
        $isCheckNews = $this->newArticle->findOneById($newsId);
        if (empty($isCheckNews)) {
            return [
                "status" => CommonConstant::EXIT_DATA,
                "msg" => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }
        try {
            DB::beginTransaction();
            $this->newArticle->updateOneById($newsId, ['active' => $dataInput['active']]);
            $dataInput['news_id'] = $newsId;
            if (empty($dataInput['attribute'])) {
                return $dataInput;
            }
            foreach ($dataInput['attribute'] as $key => $item) {
                $isCheck = $this->newArticleEav->findOneByCredentials(['namespace' => $newsId, 'attribute' => $key]);
                if (!empty($isCheck)) {
                    if (empty($item)) {
                        $this->newArticleEav->deleteOneById($isCheck->id);
                        continue;
                    }
                    $this->newArticleEav->updateOneByCondition(['namespace' => $newsId, 'attribute' => $key], ['value' => $item]);
                } else {
                    if (empty($item)) {
                        continue;
                    }
                    $dataNewEav = [
                        'attribute' => $key,
                        'namespace' => $newsId,
                        'type' => CommonConstant::STATUS_ACTIVE,
                        'value' => $item
                    ];
                    $this->newArticleEav->create($dataNewEav);
                }
            }
            DB::commit();

            return $dataInput;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getNewsDetail($newsId): array
    {
        $isCheckNews = $this->newArticle->findOneById($newsId)->toArray();
        if (empty($isCheckNews)) {
            return [
                "status" => CommonConstant::ERROR_CODE,
                "msg" => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
        $newsEav = $this->convertDataNewsEav($this->newArticleEav->findManyBy('namespace', $newsId));
        return array_merge($isCheckNews, $newsEav);

    }

    public function deleteNews($id): array
    {
        try {
            $this->newArticle->deleteOneById($id);
            $this->newArticleEav->deleteManyBy('namespace', $id);
            return ['id' => $id];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    private function convertDataNewsEav($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value['attribute']] = $value['value'];
        }
        return $result;
    }
}
