<?php

namespace App\Services;

use App\Services\CommonConstants;
use App\Services\ApiServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\TrackLink\TrackLinkRepository;
use Illuminate\Support\Facades\URL;


/**
 * Class ConvertUtil
 * @package Core\Util
 */
class TrackLinkServices
{
    protected TrackLinkRepository $trackLinkRepository;
    protected ApiServices $apiServices;

    public function __construct(
        TrackLinkRepository $trackLinkRepository,
        ApiServices         $apiServices
    )
    {
        $this->trackLinkRepository = $trackLinkRepository;
        $this->apiServices = $apiServices;
    }

    public function createGlobalTrackLink($name): array
    {
        try {
            DB::beginTransaction();
            $dataInsert = [
                'tracking_code' => URL::to("/") . '/?gtck=' . $this->apiServices->generateTrackingCode(),
                'name' => $name,
                'type' => CommonConstant::GLOBAL_LINK
            ];
            $result = $this->trackLinkRepository->create($dataInsert);
            DB::commit();
            $dataInsert['id'] = $result->id;
            return $dataInsert;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function updateNameGlobalLink($id, $name): array
    {
        try {
            DB::beginTransaction();
            $isCheck = $this->trackLinkRepository->findOneById($id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->trackLinkRepository->updateOneById($id, ['name' => $name]);
            DB::commit();
            return ['id' => $id, 'name' => $name];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getDetailGlobalLink($id)
    {
        try {
            $isCheck = $this->trackLinkRepository->findOneById($id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            return $isCheck;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getListGlobalLink(): array
    {
        $dataResult = null;
        try {
            $data = $this->trackLinkRepository->paginate();
            if (empty($data['data'])) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $dataResult['data'] = $data['data'];
            $dataResult['paginate'] = $this->apiServices->getPaginate($data);
            return $dataResult;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
