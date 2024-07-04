<?php

namespace App\Services;

use App\Repositories\Area\LargeAreaRepository;
use App\Repositories\AreaEav\LargeAreaEavRepository;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class LargeAreaServices
{
    protected LargeAreaRepository $largeAreaRepository;
    protected LargeAreaEavRepository $largeAreaEav;

    public function __construct(LargeAreaRepository $largeAreaRepository, LargeAreaEavRepository $largeAreaEav)
    {
        $this->largeAreaRepository = $largeAreaRepository;
        $this->largeAreaEav = $largeAreaEav;
    }

    /**
     * @param array $selectData
     * @return array
     */
    public function getListLargeArea(array $selectData = ['*']): array
    {
        $data = $this->largeAreaRepository->convertListLargeArea($selectData);
        return [
            'data' => $data,
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailLargeArea(int $id): array
    {
        $this->largeAreaRepository->findOneById($id);

        try {
            $data = $this->largeAreaRepository->getDetailLargeArea($id);

            if (empty($data)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }

            return [
                'data' => $data,
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
    public function createLargeArea($dataCreate): array
    {
        try {
            $orderNumber = 1;
            /*$lastId = $this->largeAreaRepository->getLatestId();*/
           /* if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }*/

            $dataCreate['order_number'] = $orderNumber;
            $dataCreate['creationTime'] = Carbon::now()->format('Ymd');
            $dataCreate['address_specifier'] = auth()->user()->id;

            DB::beginTransaction();

            $result = $this->largeAreaRepository->create($dataCreate);

            if (!empty($dataCreate['attribute'])) {
                foreach ($dataCreate['attribute'] as $key => $item) {
                    if (empty($item)) {
                        continue;
                    }

                    $dataLargeAreaEav = null;
                    $dataLargeAreaEav = [
                        'attribute' => $key,
                        'namespace' => $result->id,
                        'type' => CommonConstant::STATUS_ACTIVE,
                        'value' => $item
                    ];
                    $this->largeAreaEav->create($dataLargeAreaEav);
                }
            }

            DB::commit();

            return $this->getLargeAreaEntity($result->id, Response::HTTP_OK);
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
     * @param array $dataUpdate
     * @return array
     */
    public function updateLargeArea(int $id, array  $dataUpdate): array
    {
        $this->largeAreaRepository->findOneById($id);

        try {
            DB::beginTransaction();

            $this->largeAreaRepository->updateOneById($id, $dataUpdate);

            if (!empty($dataUpdate['attribute'])) {
                foreach ($dataUpdate['attribute'] as $key => $item) {
                    if (empty($item)) {
                        continue;
                    }

                    $isCheck = $this->largeAreaEav->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                    if (!empty($isCheck)) {
                        if (empty($item)) {
                            $this->largeAreaEav->deleteOneById($isCheck->id);
                            continue;
                        }
                        $this->largeAreaEav->updateOneByCondition(['namespace' => $id, 'attribute' => $key], ['value' => $item]);
                    } else {
                        if (empty($item)) {
                            continue;
                        }
                        $dataLargeAreaEav = [
                            'attribute' => $key,
                            'namespace' => $id,
                            'type' => CommonConstant::STATUS_ACTIVE,
                            'value' => $item
                        ];
                        $this->largeAreaEav->create($dataLargeAreaEav);
                    }
                }
            }

            DB::commit();

            return $this->getLargeAreaEntity($id);
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
    public function deleteLargeArea(int $id): array
    {
        $this->largeAreaRepository->findOneById($id);

        try {
            $this->largeAreaRepository->deleteOneById($id);
            $this->largeAreaEav->deleteManyBy('namespace', $id);

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
    public function getLargeAreaEntity(int $id, $status = null): array
    {
        $data = $this->largeAreaRepository->findOneById($id);

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
