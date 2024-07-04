<?php

namespace App\Services;

use App\Services\ApiServices;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\RentalSpaceCoupon\RentalSpaceCouponRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class CouponServices
{
    protected RentalSpaceCouponRepository $rentalSpaceCouponRepository;
    protected ApiServices $apiServices;

    public function __construct(
        RentalSpaceCouponRepository $rentalSpaceCouponRepository,
        ApiServices                 $apiServices

    )
    {
        $this->rentalSpaceCouponRepository = $rentalSpaceCouponRepository;
        $this->apiServices = $apiServices;
    }

    public function createCoupon($dataInput)
    {
        try {
            DB::beginTransaction();
            $dataInsert = [
                'name' => $dataInput['name'],
                'master' => $dataInput['master'] ?? 1,
                'enabled' => $dataInput['enabled'] ?? 1,
                'mail_text' => $dataInput['mail_text'] ?? null,
                'memo' => $dataInput['memo'] ?? null,
                'number_of_people' => $dataInput['number_of_people'] ?? null,
                'code' => $dataInput['code'],
                'plan_ids' => $dataInput['plan_ids'] ?? null,
                'space_ids' => $dataInput['space_ids'] ?? null,
                'valid_from' => $dataInput['valid_from'] ?? null,
                'valid_to' => $dataInput['valid_to'] ?? null,
                'usable_from' => $dataInput['valid_from'] ?? null,
                'usable_to' => $dataInput['valid_to'] ?? null,
                'discount_percentage' => $dataInput['discount_percentage'],
                'days_of_the_week' => isset($dataInput['days_of_the_week']) ? json_encode($dataInput['days_of_the_week']) : null,
            ];
            $result = $this->rentalSpaceCouponRepository->create($dataInsert);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function updateCoupon($id, $dataUpdate): array
    {
        try {
            $isCheck = $this->rentalSpaceCouponRepository->findOneBy('id', $id);
            if (empty($isCheck) || empty($dataUpdate)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            if (!empty($dataUpdate['days_of_the_week'])) {
                $dataUpdate['days_of_the_week'] = json_encode($dataUpdate['days_of_the_week']);
            }
            DB::beginTransaction();
            $this->rentalSpaceCouponRepository->updateOneById($id, $dataUpdate);
            DB::commit();
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function getDetailCoupon($id): array
    {
        try {
            $isCheck = $this->rentalSpaceCouponRepository->findOneBy('id', $id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $dataResult = $isCheck->toArray();
            if (!empty($dataResult['days_of_the_week'])) {
                $dataResult['days_of_the_week'] = json_decode($dataResult['days_of_the_week']);
            }
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

    public function getListCoupon(): array
    {
        $dataResult = null;
        try {
            $listCoupon = $this->rentalSpaceCouponRepository->findAll();
            if (empty($listCoupon)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => $dataResult
                ];
            }
            foreach ($listCoupon->toArray() as $item) {
                if (!empty($item['days_of_the_week'])) {
                    $item['days_of_the_week'] = json_decode($item['days_of_the_week']);
                }
                $dataResult[] = $item;
            }
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


    /**
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        try {
            $this->rentalSpaceCouponRepository->deleteOneById($id);
            return ['id' => $id];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $request
     * @param string[] $select
     * @return array
     */
    public function handleFilterCoupon($request, array $select = ['*']): array
    {
        try {
            $search = $request->all();

            return $this->rentalSpaceCouponRepository->handleFilterCoupon($select, $search);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
