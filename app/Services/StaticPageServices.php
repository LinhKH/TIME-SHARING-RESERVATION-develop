<?php

namespace App\Services;

use App\Services\ApiServices;
use App\Services\CommonConstants;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\StaticPageArticle\StaticPageArticleRepository;
use App\Repositories\StaticPageArticleEav\StaticPageArticleEavRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class StaticPageServices
{
    protected StaticPageArticleRepository $staticPageArticleRepository;
    protected StaticPageArticleEavRepository $staticPageArticleEavRepository;
    protected ApiServices $apiServices;

    public function __construct(
        StaticPageArticleRepository    $staticPageArticleRepository,
        StaticPageArticleEavRepository $staticPageArticleEavRepository,
        ApiServices                    $apiServices

    )
    {
        $this->staticPageArticleRepository = $staticPageArticleRepository;
        $this->staticPageArticleEavRepository = $staticPageArticleEavRepository;
        $this->apiServices = $apiServices;
    }


    public function getListStaticPage(): array
    {
        try {
            $dataResult = null;
            $listStaticPage = $this->staticPageArticleRepository->paginate(CommonConstant::PER_PAGE);
            if (empty($listStaticPage['data'])) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => $dataResult
                ];
            }
            foreach ($listStaticPage['data'] as $key => $item) {
                $tmpEav = null;
                $tmpEav = $this->convertDataStaticPageEav($this->staticPageArticleEavRepository->findManyBy('namespace', $item['id'])->toArray());
                $dataResult['data'][] = array_merge($item, $tmpEav);
            }
            $dataResult['pagination'] = $this->apiServices->getPaginate($listStaticPage);
            return $dataResult;
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function createStaticPageArticle($dataInput): array
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
            $resultCreateStaticPage = $this->staticPageArticleRepository->create([]);
            if (!empty($dataInput['attribute'])) {
                foreach ($dataInput['attribute'] as $key => $item) {
                    $staticPageEav = null;
                    if (!empty($item)) {
                        $staticPageEav = [
                            'attribute' => $key,
                            'namespace' => $resultCreateStaticPage->id,
                            'type' => CommonConstant::STATUS_ACTIVE,
                            'value' => $item
                        ];
                        $this->staticPageArticleEavRepository->create($staticPageEav);
                    }
                }
            }
            DB::commit();
            return ['static_page_id' => $resultCreateStaticPage->id, 'msg' => CommonConstant::MSG_SUCCESSFUL];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function updateStaticPageArticle($staticPageId, $dataInput): array
    {
        if (empty($dataInput)) {
            return [
                "status" => CommonConstant::ERROR_CODE,
                "msg" => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
        $isCheckPage = $this->staticPageArticleRepository->findOneById($staticPageId);
        if (empty($isCheckPage)) {
            return [
                "status" => CommonConstant::EXIT_DATA,
                "msg" => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }
        try {
            DB::beginTransaction();
            $dataInput['static_page_id'] = $staticPageId;
            if (empty($dataInput['attribute'])) {
                return $dataInput;
            }
            foreach ($dataInput['attribute'] as $key => $item) {
                $isCheck = $this->staticPageArticleEavRepository->findOneByCredentials(['namespace' => $staticPageId, 'attribute' => $key]);
                if (!empty($isCheck)) {
                    if (empty($item)) {
                        $this->staticPageArticleEavRepository->deleteOneById($isCheck->id);
                        continue;
                    }
                    $this->staticPageArticleEavRepository->updateOneByCondition(['namespace' => $staticPageId, 'attribute' => $key], ['value' => $item]);
                } else {
                    if (empty($item)) {
                        continue;
                    }
                    $dataNewEav = [
                        'attribute' => $key,
                        'namespace' => $staticPageId,
                        'type' => CommonConstant::STATUS_ACTIVE,
                        'value' => $item
                    ];
                    $this->staticPageArticleEavRepository->create($dataNewEav);
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

    public function deleteStaticPage($id): array
    {
        try {
            $this->staticPageArticleRepository->deleteOneById($id);
            $this->staticPageArticleEavRepository->deleteManyBy('namespace', $id);
            return ['id' => $id];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function getDetail($id): array
    {
        $dataResult = null;
        try {
            $data = $this->staticPageArticleRepository->findOneById($id);

            if (empty($data)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $dataEav = $this->staticPageArticleEavRepository->findManyBy('namespace', $id);
            $dataResult = $data->toArray();
            if (!empty($dataEav)) {
                $dataResult = array_merge($dataResult, $this->convertDataStaticPageEav($dataEav));
            }
            return $dataResult;
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    private function convertDataStaticPageEav($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value['attribute']] = $value['value'];
        }
        return $result;
    }
}
