<?php

namespace App\Services;

use App\Models\FooterLink;
use App\Models\FooterLinkCategory;
use App\Models\RentalSpaceEquipmentInformation;
use Illuminate\Support\Facades\Storage;
use App\Models\RentalSpaceUsePurpose;
use App\Services\ApiServices;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\RentalSpaceUsePurpose\RentalSpaceUsePurposeRepository;
use App\Repositories\RentalSpaceUsePurposeEav\RentalSpaceUsePurposeEavRepository;
use App\Repositories\RentalSpaceUsePurposeImage\RentalSpaceUsePurposeImageRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class PurposeUseServices
{
    protected RentalSpaceUsePurposeRepository $purposeRepository;
    protected RentalSpaceUsePurposeEavRepository $purposeEavRepository;
    protected RentalSpaceUsePurposeImageRepository $purposeImageRepository;
    protected ApiServices $apiServices;

    public function __construct(
        RentalSpaceUsePurposeRepository      $purposeRepository,
        RentalSpaceUsePurposeEavRepository   $purposeEavRepository,
        RentalSpaceUsePurposeImageRepository $purposeImageRepository,
        ApiServices                          $apiServices

    ) {
        $this->purposeRepository = $purposeRepository;
        $this->purposeEavRepository = $purposeEavRepository;
        $this->purposeImageRepository = $purposeImageRepository;
        $this->apiServices = $apiServices;
    }


    public function createPurposeUse($categoryId, $dataInput): array
    {
        try {
            $orderNumber = 1;
            $lastId = RentalSpaceUsePurpose::latest()->first();
            if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }
            DB::beginTransaction();
            $dataInsert = [
                'active' => $dataInput['active'],
                'category_id' => $categoryId,
                'legacy_id' => CommonConstant::STATUS_ACTIVE,
                'order_number' => $orderNumber,
                'equipment_information_icons_ids' => isset($dataInput['equipment_information_icons_ids']) ? json_encode($dataInput['equipment_information_icons_ids']) : null,
                'equipment_information_ids' => isset($dataInput['equipment_information_ids']) ? json_encode($dataInput['equipment_information_ids']) : null,
                'equipment_information_ids_mobile' => isset($dataInput['equipment_information_ids_mobile']) ? json_encode($dataInput['equipment_information_ids_mobile']) : null,
            ];
            $result = $this->purposeRepository->create($dataInsert);
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
                    $this->purposeEavRepository->create($dataEav);
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

    public function updatePurposeUse($id, $dataUpdate): array
    {
        try {
            DB::beginTransaction();
            $update = [
                'active' => $dataUpdate['active'],
                'legacy_id' => CommonConstant::STATUS_ACTIVE,
                'equipment_information_icons_ids' => isset($dataUpdate['equipment_information_icons_ids']) ? json_encode($dataUpdate['equipment_information_icons_ids']) : null,
                'equipment_information_ids' => isset($dataUpdate['equipment_information_ids']) ? json_encode($dataUpdate['equipment_information_ids']) : null,
                'equipment_information_ids_mobile' => isset($dataUpdate['equipment_information_ids_mobile']) ? json_encode($dataUpdate['equipment_information_ids_mobile']) : null,
            ];
            $this->purposeRepository->updateOneById($id, $update);
            $dataUpdate['id'] = $id;
            if (empty($dataUpdate['attribute'])) {
                return $dataUpdate;
            }
            foreach ($dataUpdate['attribute'] as $key => $value) {
                $isCheck = $this->purposeEavRepository->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                if (empty($value) && !empty($isCheck)) {
                    $this->purposeEavRepository->deleteOneById($isCheck->id);
                    continue;
                }
                $dataEav = [
                    'attribute' => $key,
                    'value' => $value,
                    'namespace' => $id,
                    'type' => CommonConstant::STATUS_ACTIVE
                ];

                if (empty($isCheck)) {
                    if (empty($value)) {
                        continue;
                    }
                    $this->purposeEavRepository->create($dataEav);
                } else {
                    $this->purposeEavRepository->updateOneById($isCheck->id, $dataEav);
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

    public function getDetailPurpose($id): array
    {
        try {
            $data = $this->purposeRepository->findOneById($id);
            if (empty($data)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $dataEav = $this->purposeEavRepository->findManyBy('namespace', $id);
            $dataResult = $data->toArray();
            $dataResult = $this->convertJson($dataResult);
            if (!empty($dataEav)) {
                $dataResult = array_merge($dataResult, $this->convertData($dataEav));
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


    /**
     * @param $category
     * @return array
     */

    public function getListByCategory($category): array
    {
        try {
            $dataResult = [];
            $data = $this->purposeRepository->paginateBy('category_id', $category)->toArray();
            if (empty($data['data'])) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            foreach ($data['data'] as $key => $item) {
                $item = $this->convertJson($item);
                $img = $this->purposeImageRepository->findOneBy('parent_id', $item['id']);
                if (!empty($img)) {
                    $item['url_img'] = Storage::url($img->s3key);
                }
                $dataEav = $this->purposeEavRepository->findManyBy('namespace', $item['id']);
                if (!empty($dataEav)) {
                    $item = array_merge($item, $this->convertData($dataEav));
                }
                $dataResult['data'][] = $item;
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

    public function uploadImagePurposeUse($id, $file, $type): array
    {
        try {
            $isCheck = $this->purposeRepository->findOneBy('id', $id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            $data = $this->apiServices->postUploadImageStorage($file, $type);
            $data['parent_id'] = $id;

            return $this->purposeImageRepository->create($data)->toArray();
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
     * @param $file
     * @return array|\Illuminate\Http\JsonResponse
     */

    public function updateImgPurpose($id, $file)
    {
        try {
            $isCheck = $this->purposeImageRepository->findOneBy('id', $id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }

            $data = $this->apiServices->postUploadImageStorage($file, $isCheck->type);
            $data['id'] = $id;
            $this->purposeImageRepository->updateOneById($id, $data);
            return $data;
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
    public function deleteImgPurpose($id): array
    {
        try {
            $isCheck = $this->purposeImageRepository->findOneBy('id', $id);
            if (empty($isCheck)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            $this->purposeImageRepository->deleteOneById($id);
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

    public function getListImgPurposeUse($id): array
    {
        try {
            $dataResult = [];
            $listImg = $this->purposeImageRepository->findManyBy('parent_id', $id);
            if (empty($listImg)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            foreach ($listImg->toArray() as $value) {
                $value['url_img'] = Storage::url($value['s3key']);
                unset($value['s3key']);
                $dataResult[] = $value;
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
     * @param $data
     * @return mixed
     */

    private function convertJson($data)
    {
        $data['equipment_information_icons_ids'] = isset($data['equipment_information_icons_ids']) ? json_decode($data['equipment_information_icons_ids']) : null;
        $data['equipment_information_ids'] = isset($data['equipment_information_ids']) ? json_decode($data['equipment_information_ids']) : null;
        $data['equipment_information_ids_mobile'] = isset($data['equipment_information_ids_mobile']) ? json_decode($data['equipment_information_ids_mobile']) : null;
        return $data;
    }


    private function convertData($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value->attribute] = $value->value;
        }
        return $result;
    }


    /**
     * @return array
     */
    public function getListPurposeUse(): array
    {
        try {
            return $this->purposeRepository->getListPurposeUse();
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    /**
     * @param int $id
     *
     * @return array
     */
    public function deletePurposeUse(int $id): array
    {
        $this->purposeRepository->findOneById($id);

        try {
            $this->purposeRepository->deleteOneById($id);

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
}
