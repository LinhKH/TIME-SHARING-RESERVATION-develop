<?php

namespace App\Http\Controllers\Bundle\ManagerSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmallAreaCreateRequest;
use App\Http\Requests\SmallAreaUpdateRequest;
use App\Services\SmallAreaServices;
use Illuminate\Http\JsonResponse;

class SmallAreaController extends Controller
{
    private SmallAreaServices $smallAreaServices;

    public function __construct(SmallAreaServices $smallAreaServices)
    {
        $this->smallAreaServices = $smallAreaServices;
    }

    /**
     * @return JsonResponse
     */
    public function getListSmallArea(): JsonResponse
    {
        $data = $this->smallAreaServices->getListSmallArea();

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDetailSmallArea(int $id): JsonResponse
    {
        $data = $this->smallAreaServices->getDetailSmallArea($id);

        return response()->json($data, 200);
    }

    /**
     * @param SmallAreaCreateRequest $request
     * @return JsonResponse
     */
    public function createSmallArea(SmallAreaCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->smallAreaServices->createSmallArea($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param SmallAreaUpdateRequest $request
     * @return JsonResponse
     */
    public function updateSmallArea(SmallAreaUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->smallAreaServices->updateSmallArea($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteSmallArea(int $id): JsonResponse
    {
        $data = $this->smallAreaServices->deleteSmallArea($id);

        return response()->json($data, 200);
    }
}
