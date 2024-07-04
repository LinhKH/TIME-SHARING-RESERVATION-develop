<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\RentalSpaceEquipmentInformation;
use App\Services\ApiServices;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\SpaceEquipmentInformation\SpaceEquipmentInformationRepository;
use App\Repositories\SpaceEquipmentInformationEav\SpaceEquipmentInformationEavRepository;
use App\Repositories\SpaceEquipmentInformationImage\SpaceEquipmentInformationImageRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class EquipmentInformationServices
{
    protected SpaceEquipmentInformationRepository $equipmentInformationRepository;
    protected SpaceEquipmentInformationEavRepository $equipmentInformationEavRepository;
    protected SpaceEquipmentInformationImageRepository $equipmentInformationImageRepository;
    protected ApiServices $apiServices;

    public function __construct(
        SpaceEquipmentInformationRepository      $equipmentInformationRepository,
        SpaceEquipmentInformationEavRepository   $equipmentInformationEavRepository,
        SpaceEquipmentInformationImageRepository $equipmentInformationImageRepository,
        ApiServices                              $apiServices

    )
    {
        $this->equipmentInformationRepository = $equipmentInformationRepository;
        $this->equipmentInformationEavRepository = $equipmentInformationEavRepository;
        $this->equipmentInformationImageRepository = $equipmentInformationImageRepository;
        $this->apiServices = $apiServices;
    }


    public function createEquipmentInformation($categoryId, $dataInput): array
    {
        try {
            $orderNumber = 1;
            $lastId = RentalSpaceEquipmentInformation::latest()->first();
            if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }
            DB::beginTransaction();
            $dataInsert = [
                'active' => $dataInput['active'],
                'category_id' => $categoryId,
                'checkbox_label_type' => $dataInput['checkbox_label_type'],
                'frequently_used' => $dataInput['frequently_used'],
                'order_number' => $orderNumber,
                'required' => $dataInput['required'],
                'string_id' => $dataInput['string_id'],
                'type' => $dataInput['string_id'],
            ];
            $result = $this->equipmentInformationRepository->create($dataInsert);
            if (!empty($dataInput['attribute'])) {
                foreach ($dataInput['attribute'] as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $dataEav = [
                        'attribute' => $key,
                        'value' => $value,
                        'namespace' => $result->id,
                        'type' => CommonConstant::STATUS_ACTIVE
                    ];
                    $this->equipmentInformationEavRepository->create($dataEav);
                }
            }
            $dataInput['id'] = $result->id;
            DB::commit();
            return ['id' => $result->id];
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
     * @param $dataUpdate
     * @return array
     */

    public function updateEquipmentInformation($id, $dataUpdate): array
    {
        try {
            DB::beginTransaction();
            $update = [
                'active' => $dataUpdate['active'],
                'checkbox_label_type' => $dataUpdate['checkbox_label_type'],
                'frequently_used' => $dataUpdate['frequently_used'],
                'required' => $dataUpdate['required'],
            ];
            $this->equipmentInformationRepository->updateOneById($id, $update);
            $dataUpdate['id'] = $id;
            if (empty($dataUpdate['attribute'])) {
                return $dataUpdate;
            }
            foreach ($dataUpdate['attribute'] as $key => $value) {
                $isCheck = $this->equipmentInformationEavRepository->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                if (empty($value) && !empty($isCheck)) {
                    $this->equipmentInformationEavRepository->deleteOneById($isCheck->id);
                    continue;
                }
                $dataEav = [
                    'attribute' => $key,
                    'value' => $value,
                    'namespace' => $id,
                    'type' => CommonConstant::STATUS_ACTIVE
                ];
                if (empty($isCheck)) {
                    $this->equipmentInformationEavRepository->create($dataEav);
                } else {
                    $this->equipmentInformationEavRepository->updateOneById($isCheck->id, $dataEav);
                }
            }
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

    /**
     * @param $id
     * @return array
     */

    public function getDetailEquipmentInformation($id): array
    {
        try {
            $data = $this->equipmentInformationRepository->findOneById($id);
            if (empty($data)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            return $this->mergeData($data->toArray());
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $category
     * @return array
     */

    public function getListByCategory($category): array
    {
        try {
            $dataResult = [];
            $data = $this->equipmentInformationRepository->paginateBy('category_id', $category)->toArray();
            if (empty($data['data'])) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            foreach ($data['data'] as $key => $item) {
                $dataResult['data'][] = $this->mergeData($item);
            }
            $dataResult['paginate'] = $this->apiServices->getPaginate($data);
            return $dataResult;
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
     * @param $file
     * @param $type
     * @return array
     */

    public function uploadImageEquipmentInformation($id, $file, $type): array
    {
        try {
            $isCheckEquipment = $this->equipmentInformationRepository->findOneBy('id', $id);
            if (empty($isCheckEquipment)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            $data = $this->apiServices->postUploadImageStorage($file, $type);
            $data['parent_id'] = $id;
            $isCheck = $this->equipmentInformationImageRepository->findOneBy('parent_id', $id);
            if (!empty($isCheck)) {
                $this->equipmentInformationImageRepository->updateOneBy('parent_id', $id, $data);
                return ['id' => $isCheck->id];
            }
            return $this->equipmentInformationImageRepository->create($data)->toArray();
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function deleteEquipmentInformation($id): array
    {
        try {
            DB::beginTransaction();
            $equipmentInformation = $this->equipmentInformationRepository->findOneById($id);
            if (empty($equipmentInformation)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->equipmentInformationRepository->deleteOneById($id);
            $this->equipmentInformationEavRepository->deleteOneByKey('namespace', $id);
            DB::commit();
            return ['id' => $id];
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
    public function deleteImgEquipmentInformation($id): array
    {
        try {
            DB::beginTransaction();
            $img = $this->equipmentInformationImageRepository->findOneBy('parent_id', $id);
            if (empty($img)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->equipmentInformationImageRepository->deleteOneBy('parent_id', $id);
            DB::commit();
            return ['id' => $id];
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
     * @return array
     */
    public function getListEquipment(): array
    {
        try {
            $dataResult = [];
            $listData = $this->equipmentInformationRepository->findAll();
            if (empty($listData)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            foreach ($listData->toArray() as $value) {
                $dataResult[$value['category_id']][] = $this->mergeData($value);
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


    public function mergeData($value)
    {
        $img = $this->equipmentInformationImageRepository->findOneBy('parent_id', $value['id']);
        if (!empty($img)) {
            $value['url_img'] = Storage::url($img->s3key);
        }
        $dataEav = $this->equipmentInformationEavRepository->findManyBy('namespace', $value['id']);
        if (!empty($dataEav)) {
            $value = array_merge($value, $this->convertData($dataEav));
        }
        return $value;
    }


    private function convertData($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value->attribute] = $value->value;
        }
        return $result;
    }
}
