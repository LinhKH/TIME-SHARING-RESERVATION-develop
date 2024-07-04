<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\TsCampaignCreateRequest;
use App\Http\Requests\Ts\TsCampaignUpdateRequest;
use App\Services\Ts\CampaignServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private CampaignServices $campaignServices;

    public function __construct(CampaignServices $campaignServices)
    {
        $this->campaignServices = $campaignServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListTsCampaign(Request $request): JsonResponse
    {
        $data = $this->campaignServices->getListTsCampaign($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailTsCampaign(int $id): JsonResponse
    {
        $data = $this->campaignServices->getDetailTsCampaign($id);

        return response()->json($data, 200);
    }

    /**
     * @param TsCampaignCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createTsCampaign(TsCampaignCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->campaignServices->createTsCampaign($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param TsCampaignUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateTsCampaign(TsCampaignUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->campaignServices->updateTsCampaign($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteTsCampaign(int $id): JsonResponse
    {
        $data = $this->campaignServices->deleteTsCampaign($id);

        return response()->json($data, 200);
    }

    /**
     * @param $spaceId
     * @return JsonResponse
     */
    public function getScheduleBySpace($spaceId): JsonResponse
    {
        $data = $this->campaignServices->getScheduleBySpaceId($spaceId);

        return response()->json($data, 200);
    }
}
