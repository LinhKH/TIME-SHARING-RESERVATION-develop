<?php

namespace App\Services\Ts;

use App\Repositories\Ts\CampaignRepository;
use App\Repositories\Ts\CampaignSpaceRepository;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CampaignServices
{
    protected CampaignRepository $campaignRepository;
    protected CampaignSpaceRepository $campaignSpaceRepository;

    public function __construct(CampaignRepository $campaignRepository, CampaignSpaceRepository $campaignSpaceRepository)
    {
        $this->campaignRepository = $campaignRepository;
        $this->campaignSpaceRepository = $campaignSpaceRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListTsCampaign($request): array
    {
        try {
            $search = $request->all();

            $data = $this->campaignRepository->getListTsCampaign($search, CommonConstant::PAGINATE_LIMIT_CAMPAIGN_WP);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK
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
    public function getDetailTsCampaign(int $id): array
    {
        $this->campaignRepository->findOneById($id);

        try {
            $data = $this->campaignRepository->getDetailTsCampaign($id);

            if (!empty($data['ts_campaign_space'])) {

                $convertDataTsCampaignSpace = [];
                foreach ($data['ts_campaign_space'] as $value) {
                    $nameSpace = $this->campaignRepository->getNameSpace($value['rental_space_id']);
                    if (!empty($nameSpace)) {
                        $value['nameSpace'] = $nameSpace['value'];
                    } else {
                        $value['nameSpace'] = null;
                    }

                    $convertDataTsCampaignSpace[] = $value;
                }
            }

            $data['ts_campaign_space'] = $convertDataTsCampaignSpace;

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
     *
     * @return array
     */
    public function createTsCampaign($dataCreate): array
    {
        try {
            DB::beginTransaction();

            if (isset($dataCreate['title_background'])) {
                $putFile = Storage::putFile('public/ts-campaign', $dataCreate['title_background'], 'public');
                $dataCreate['title_background'] = Storage::url($putFile);
            }

            if (isset($dataCreate['title_background_recommendation'])) {
                $putFile = Storage::putFile('public/ts-campaign', $dataCreate['title_background_recommendation'], 'public');
                $dataCreate['title_background_recommendation'] = Storage::url($putFile);
            }

            if (!empty($dataCreate['campaign_spaces'])) {
                $dataCampaignSpaces = $dataCreate['campaign_spaces'];
            }

            unset($dataCreate['campaign_spaces']);
            $campaign = $this->campaignRepository->create($dataCreate);

            if (!empty($dataCampaignSpaces)) {

                foreach ($dataCampaignSpaces as $value) {
                    if (!empty($value['image'])) {
                        $putFile = Storage::putFile('public/ts-campaign-spaces', $value['image'], 'public');
                        $value['image'] = Storage::url($putFile);
                    }

                    $value['ts_campaign_id'] = $campaign->id;

                    $this->campaignSpaceRepository->create($value);
                }
            }

            DB::commit();

            return [
                'id' => $campaign->id,
                'status' => Response::HTTP_OK,
            ];
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
     *
     * @return array
     */
    public function updateTsCampaign(int $id, array $dataUpdate): array
    {
        $this->campaignRepository->findOneById($id);

        try {
            DB::beginTransaction();

            if (isset($dataUpdate['title_background'])) {
                $putFile = Storage::putFile('public/ts-campaign', $dataUpdate['title_background'], 'public');
                $dataUpdate['title_background'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['title_background_recommendation'])) {
                $putFile = Storage::putFile('public/ts-campaign', $dataUpdate['title_background_recommendation'], 'public');
                $dataUpdate['title_background_recommendation'] = Storage::url($putFile);
            }

            if (!empty($dataUpdate['campaign_spaces'])) {
                $dataCampaignSpaces = $dataUpdate['campaign_spaces'];
            }

            unset($dataUpdate['campaign_spaces']);

            $this->campaignRepository->updateOneById($id, $dataUpdate);

            if (!empty($dataCampaignSpaces)) {
                $idsCampaignSpace = $this->campaignSpaceRepository->getIdCampaign($id);

                if (!empty($idsCampaignSpace)) {
                    $this->campaignSpaceRepository->deleteManyByIds($idsCampaignSpace);
                }

                foreach ($dataCampaignSpaces as $value) {
                    if (!empty($value['image'])) {
                        $putFile = Storage::putFile('public/ts-campaign-spaces', $value['image'], 'public');
                        $value['image'] = Storage::url($putFile);
                    }

                    $value['ts_campaign_id'] = $id;

                    $this->campaignSpaceRepository->create($value);
                }
            }

            DB::commit();

            return [
                'id' => $id,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            echo $e->getMessage();
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
     *
     * @return array
     */
    public function deleteTsCampaign(int $id): array
    {
        $this->campaignRepository->findOneById($id);

        try {
            DB::beginTransaction();

            $this->campaignRepository->deleteOneById($id);

            $idsCampaignSpace = $this->campaignSpaceRepository->getIdCampaign($id);

            if (!empty($idsCampaignSpace)) {
                $this->campaignSpaceRepository->deleteManyByIds($idsCampaignSpace);
            }

            DB::commit();

            return [
                'id' => $id,
                'status' => Response::HTTP_OK,
            ];
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
    public function getScheduleBySpaceId($id): array
    {
        try {
            $dataResult = [];
            $data = $this->campaignSpaceRepository->findOneBy('rental_space_id', $id);
            if (empty($data)) {
                return [
                    'status' => CommonConstant::ERROR_CODE,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => $dataResult
                ];
            }

            $dataResult = $data['schedule'];
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $dataResult
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
