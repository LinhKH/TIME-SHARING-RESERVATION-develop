<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\RollBannerCreateRequest;
use App\Services\Ts\RollBannerServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RollBannerController extends Controller
{
    private RollBannerServices $rollBannerServices;

    public function __construct(RollBannerServices $rollBannerServices)
    {
        $this->middleware('auth:api', ['except' => ['getListRollBanner', 'getDetailRollBanner']]);
        $this->rollBannerServices = $rollBannerServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListRollBanner(Request $request): JsonResponse
    {
        $data = $this->rollBannerServices->getListRollBanner($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailRollBanner(int $id): JsonResponse
    {
        $data = $this->rollBannerServices->getDetailRollBanner($id);

        return response()->json($data, 200);
    }

    /**
     * @param RollBannerCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createRollBanner(RollBannerCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->rollBannerServices->createRollBanner($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param RollBannerCreateRequest $request
     *
     * @return JsonResponse
     */
    public function updateRollBanner(RollBannerCreateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->rollBannerServices->updateRollBanner($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteRollBanner(int $id): JsonResponse
    {
        $data = $this->rollBannerServices->deleteRollBanner($id);

        return response()->json($data, 200);
    }
}
