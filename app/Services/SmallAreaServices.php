<?php

namespace App\Services;

use App\Repositories\Area\SmallAreaRepository;
use App\Repositories\AreaEav\SmallAreaEavRepository;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class SmallAreaServices
{
    protected SmallAreaRepository $smallAreaRepository;
    protected SmallAreaEavRepository $smallAreaEav;

    public function __construct(SmallAreaRepository $smallAreaRepository, SmallAreaEavRepository $smallAreaEav)
    {
        $this->smallAreaRepository = $smallAreaRepository;
        $this->smallAreaEav = $smallAreaEav;
    }

    /**
     * @return array
     */
    public function getListSmallArea(): array
    {
        return $this->smallAreaRepository->getListSmallArea();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailSmallArea(int $id): array
    {
        $this->smallAreaRepository->findOneById($id);

        try {
            $detailSmallArea = $this->smallAreaRepository->getDetailSmallArea($id);

            return [
                'data' => $detailSmallArea,
                'status' => Response::HTTP_OK,
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
     * @param $dataCreate
     * @return array
     */
    public function createSmallArea($dataCreate): array
    {
        /*try {*/
            $orderNumber = 1;
            /*$lastId = $this->smallAreaRepository->getLatestId();*/

           /* if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }*/

            $dataCreate['order_number'] = $orderNumber;
            $dataCreate['creationTime'] = Carbon::now()->format('Ymd');
            $dataCreate['address_specifier'] = auth()->user()->id;

            DB::beginTransaction();
            $result = $this->smallAreaRepository->create($dataCreate);

            if (!empty($dataCreate['attribute'])) {
                foreach ($dataCreate['attribute'] as $key => $item) {
                    if (empty($item)) {
                        continue;
                    }

                    $dataSmallAreaEav = null;
                    $dataSmallAreaEav = [
                        'attribute' => $key,
                        'namespace' => $result->id,
                        'type' => CommonConstant::STATUS_ACTIVE,
                        'value' => $item
                    ];

                    $this->smallAreaEav->create($dataSmallAreaEav);
                }
            }

            DB::commit();

            return $this->getSmallAreaEntity($result->id, Response::HTTP_OK);
        /*} catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }*/
    }

    /**
     * @param int $id
     * @param array $dataUpdate
     * @return array
     */
    public function updateSmallArea(int $id, array  $dataUpdate): array
    {
        $this->smallAreaRepository->findOneById($id);

        try {
            DB::beginTransaction();

            $this->smallAreaRepository->updateOneById($id, $dataUpdate);

            if (!empty($dataUpdate['attribute'])) {
                foreach ($dataUpdate['attribute'] as $key => $item) {
                    if (empty($item)) {
                        continue;
                    }

                    $isCheck = $this->smallAreaEav->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                    if (!empty($isCheck)) {
                        if (empty($item)) {
                            $this->smallAreaEav->deleteOneById($isCheck->id);
                            continue;
                        }
                        $this->smallAreaEav->updateOneByCondition(['namespace' => $id, 'attribute' => $key], ['value' => $item]);
                    } else {
                        if (empty($item)) {
                            continue;
                        }
                        $dataSmallAreaEav = [
                            'attribute' => $key,
                            'namespace' => $id,
                            'type' => CommonConstant::STATUS_ACTIVE,
                            'value' => $item
                        ];
                        $this->smallAreaEav->create($dataSmallAreaEav);
                    }
                }
            }

            DB::commit();

            return $this->getSmallAreaEntity($id);
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
     * @param int $id
     * @return array
     */
    public function deleteSmallArea(int $id): array
    {
        $this->smallAreaRepository->findOneById($id);

        try {
            $checkParent = $this->smallAreaRepository->getDetailSmallArea($id);

            if (empty($checkParent['parent_id']) && !empty($checkParent['area_groups'])) {
                return [
                    'status' => Response::HTTP_FORBIDDEN,
                    'msg' => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }

            $this->smallAreaRepository->deleteOneById($id);
            $this->smallAreaEav->deleteManyBy('namespace', $id);

            return [
                'id' => $id,
                'status' => Response::HTTP_OK,
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
     * @param int  $id
     * @param $status
     * @return array
     */
    public function getSmallAreaEntity(int $id, $status = null): array
    {
        $data = $this->smallAreaRepository->findOneById($id);

        if (is_null($data)) {
            return [
                "status" => CommonConstant::EXIT_DATA,
                "msg" => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }

        return [
            'data' => $data->toArray(),
            'status' => $status ?? Response::HTTP_OK
        ];
    }
}
