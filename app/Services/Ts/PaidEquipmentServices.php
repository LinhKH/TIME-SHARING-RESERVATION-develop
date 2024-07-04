<?php

namespace App\Services\Ts;

use App\Repositories\Ts\PaidEquipmentRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PaidEquipmentServices
{
    protected PaidEquipmentRepository $paidEquipmentRepository;

    public function __construct(PaidEquipmentRepository $paidEquipmentRepository)
    {
        $this->paidEquipmentRepository = $paidEquipmentRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListPaidEquipment($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->paidEquipmentRepository->getListPaidEquipment($filter, CommonConstant::PAGINATE_LIMIT_PAID_EQUIPMENT_WP);

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
    public function getDetailPaidEquipment(int $id): array
    {
        $this->paidEquipmentRepository->findOneById($id);

        try {
            $data = $this->paidEquipmentRepository->getDetailPaidEquipment($id);

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
    public function createPaidEquipment($dataCreate): array
    {
        try {
            if (isset($dataCreate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataCreate['file'], 'public');
                $dataCreate['file'] = Storage::url($putFile);
            }

            if (empty($dataCreate['slug'])) {
                $dataCreate['slug'] = $dataCreate['name'];
            }

            $result = $this->paidEquipmentRepository->create($dataCreate);

            return $this->getPaidEquipmentEntity($result->id);
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
    public function updatePaidEquipment(int $id, array $dataUpdate): array
    {
        $this->paidEquipmentRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->paidEquipmentRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->paidEquipmentRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->paidEquipmentRepository->updateOneById($id, $dataUpdate);

            return $this->getPaidEquipmentEntity($id);
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
    public function deletePaidEquipment(int $id): array
    {
        $this->paidEquipmentRepository->findOneById($id);

        try {
            $this->paidEquipmentRepository->deleteOneById($id);

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
    public function getPaidEquipmentEntity(int $id): array
    {
        $data = $this->paidEquipmentRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
