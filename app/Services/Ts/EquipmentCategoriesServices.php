<?php

namespace App\Services\Ts;

use App\Repositories\Ts\EquipmentCategoriesRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class EquipmentCategoriesServices
{
    protected EquipmentCategoriesRepository $equipmentCategoriesRepository;

    public function __construct(EquipmentCategoriesRepository $equipmentCategoriesRepository)
    {
        $this->equipmentCategoriesRepository = $equipmentCategoriesRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListEquipmentCategories($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->equipmentCategoriesRepository->getListEquipmentCategories($filter, CommonConstant::PAGINATE_LIMIT_EQUIPMENT_CATEGORY_WP);

            return [
                'status' => Response::HTTP_OK,
                'data' => $data
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
     * @param int $id
     *
     * @return array
     */
    public function getDetailEquipmentCategories(int $id): array
    {
        $this->equipmentCategoriesRepository->findOneById($id);

        try {
            $data = $this->equipmentCategoriesRepository->getDetailEquipmentCategories($id);

            return [
                'status' => Response::HTTP_OK,
                'data' => $data
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
     *
     * @return array
     */
    public function createEquipmentCategories($dataCreate): array
    {
        try {
            if (empty($dataCreate['slug'])) {
                $dataCreate['slug'] = $dataCreate['name'];
            }

            $result = $this->equipmentCategoriesRepository->create($dataCreate);

            return $this->getEquipmentCategoriesEntity($result->id);
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
     * @param array $dataUpdate
     *
     * @return array
     */
    public function updateEquipmentCategories(int $id, array $dataUpdate): array
    {
        $this->equipmentCategoriesRepository->findOneById($id);

        try {
            if (isset($dataUpdate['name'])) {
                $checkName = $this->equipmentCategoriesRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->equipmentCategoriesRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->equipmentCategoriesRepository->updateOneById($id, $dataUpdate);

            return $this->getEquipmentCategoriesEntity($id);
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
    public function deleteEquipmentCategories(int $id): array
    {
        $this->equipmentCategoriesRepository->findOneById($id);

        try {
            $this->equipmentCategoriesRepository->deleteOneById($id);

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
     * @param int $id
     *
     * @return array
     */
    public function getEquipmentCategoriesEntity(int $id): array
    {
        $data = $this->equipmentCategoriesRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
