<?php

namespace App\Services\Ts;

use App\Repositories\Ts\RollBannerRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class RollBannerServices
{
    protected RollBannerRepository $rollBannerRepository;

    public function __construct(RollBannerRepository $rollBannerRepository)
    {
        $this->rollBannerRepository = $rollBannerRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListRollBanner($request): array
    {
        try {
            $search = $request->all();
            $data = $this->rollBannerRepository->getListRollBanner($search, CommonConstant::PAGINATE_LIMIT_ROLLBANNER_WP);

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
    public function getDetailRollBanner(int $id): array
    {
        $this->rollBannerRepository->findOneById($id);

        try {
            $data = $this->rollBannerRepository->getDetailRollBanner($id);

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
    public function createRollBanner($dataCreate): array
    {
        try {
            if (!empty($dataCreate['image'])) {
                $putFile = Storage::putFile('public/roll-banner', $dataCreate['image'], 'public');
                $dataCreate['image'] = Storage::url($putFile);
            }

            $result = $this->rollBannerRepository->create($dataCreate);

            return $this->getRollBannerEntity($result->id);
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
    public function updateRollBanner(int $id, array $dataUpdate): array
    {
        $this->rollBannerRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['image'])) {
                $putFile = Storage::putFile('public/roll-banner', $dataUpdate['image'], 'public');
                $dataUpdate['image'] = Storage::url($putFile);
            }

            $this->rollBannerRepository->updateOneById($id, $dataUpdate);

            return $this->getRollBannerEntity($id);
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
    public function deleteRollBanner(int $id): array
    {
        $this->rollBannerRepository->findOneById($id);

        try {
            $this->rollBannerRepository->deleteOneById($id);

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
    public function getRollBannerEntity(int $id): array
    {
        $data = $this->rollBannerRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
