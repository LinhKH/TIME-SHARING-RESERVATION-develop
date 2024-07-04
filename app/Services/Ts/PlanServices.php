<?php

namespace App\Services\Ts;

use App\Repositories\Ts\PlanRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PlanServices
{
    protected PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListPlan($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->planRepository->getListPlan($filter, CommonConstant::PAGINATE_LIMIT_PLAN_WP);

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
    public function getDetailPlan(int $id): array
    {
        $this->planRepository->findOneById($id);

        try {
            $data = $this->planRepository->getDetailPlan($id);

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
    public function createPlan($dataCreate): array
    {
        try {
            if(empty($dataCreate['slug'])){
                $dataCreate['slug'] = $dataCreate['name'];
            }

            $result = $this->planRepository->create($dataCreate);

            return $this->getPlanEntity($result->id);
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
    public function updatePlan(int $id, array $dataUpdate): array
    {
        $this->planRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->planRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->planRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->planRepository->updateOneById($id, $dataUpdate);

            return $this->getPlanEntity($id);
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
    public function deletePlan(int $id): array
    {
        $this->planRepository->findOneById($id);

        try {
            $this->planRepository->deleteOneById($id);

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
    public function getPlanEntity(int $id): array
    {
        $data = $this->planRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
