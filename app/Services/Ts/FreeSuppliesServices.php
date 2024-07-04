<?php

namespace App\Services\Ts;

use App\Repositories\Ts\FreeSuppliesRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FreeSuppliesServices
{
    protected FreeSuppliesRepository $freeSuppliesRepository;

    public function __construct(FreeSuppliesRepository $freeSuppliesRepository)
    {
        $this->freeSuppliesRepository = $freeSuppliesRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListFreeSupplies($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->freeSuppliesRepository->getListFreeSupplies($filter, CommonConstant::PAGINATE_LIMIT_FREE_SUPPLIES_WP);

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
    public function getDetailFreeSupplies(int $id): array
    {
        $this->freeSuppliesRepository->findOneById($id);

        try {
            $data = $this->freeSuppliesRepository->getDetailFreeSupplies($id);

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
    public function createFreeSupplies($dataCreate): array
    {
        try {
            if (isset($dataCreate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataCreate['file'], 'public');
                $dataCreate['file'] = Storage::url($putFile);
            }

            if (empty($dataCreate['slug'])) {
                $dataCreate['slug'] = $dataCreate['name'];
            }

            $result = $this->freeSuppliesRepository->create($dataCreate);

            return $this->getFreeSuppliesEntity($result->id);
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
    public function updateFreeSupplies(int $id, array $dataUpdate): array
    {
        $this->freeSuppliesRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->freeSuppliesRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->freeSuppliesRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->freeSuppliesRepository->updateOneById($id, $dataUpdate);

            return $this->getFreeSuppliesEntity($id);
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
    public function deleteFreeSupplies(int $id): array
    {
        $this->freeSuppliesRepository->findOneById($id);

        try {
            $this->freeSuppliesRepository->deleteOneById($id);

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
    public function getFreeSuppliesEntity(int $id): array
    {
        $data = $this->freeSuppliesRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
