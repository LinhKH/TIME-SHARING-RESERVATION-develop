<?php

namespace App\Services\Ts;

use App\Repositories\TsNews\NewsRepository;
use App\Services\CommonConstant;
use App\Services\ApiServices;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class NewsServices
{
    protected NewsRepository $newsRepository;
    protected ApiServices $apiServices;

    public function __construct(NewsRepository $newsRepository, ApiServices $apiServices)
    {
        $this->newsRepository = $newsRepository;
        $this->apiServices = $apiServices;
    }

    /**
     * @param $data
     * @return array
     */
    public function createNews($data): array
    {

        try {
            $result = $this->newsRepository->create($data);
            return ['id' => $result->id];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function updateNews($id, $data): array
    {
        try {
            $isCheck = $this->newsRepository->findOneBy('id', $id);
            if (empty($data) || empty($isCheck)) {
                return [
                    'status' => CommonConstant::ERROR_CODE,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->newsRepository->updateOneById($id, $data);
            $data['id'] = $id;
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @return array
     */
    public function getListNews(): array
    {
        try {
            $data = $this->newsRepository->paginate();
            $dataResult['data'] = $data['data'] ?? [];
            $dataResult['paginate'] = $this->apiServices->getPaginate($data);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $dataResult
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function getDetail($id): array
    {
        try {
            $isCheck = $this->newsRepository->findOneBy('id', $id);
            if (empty($isCheck)) {
                return [
                    'status' => CommonConstant::ERROR_CODE,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $isCheck
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

}
