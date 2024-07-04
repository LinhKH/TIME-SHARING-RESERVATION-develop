<?php

namespace App\Http\Controllers\Bundle\ManagerSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\LargeAreaRequest;
use App\Services\LargeAreaServices;
use Illuminate\Http\JsonResponse;

class LargeAreaController extends Controller
{
    private LargeAreaServices $largeAreaServices;

    public function __construct(LargeAreaServices $largeAreaServices)
    {
        $this->largeAreaServices = $largeAreaServices;
    }

    /**
     * @return JsonResponse
     */
    public function getListLargeArea(): JsonResponse
    {
        $data = $this->largeAreaServices->getListLargeArea();

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDetailLargeArea(int $id): JsonResponse
    {
        $data = $this->largeAreaServices->getDetailLargeArea($id);

        return response()->json($data, 200);
    }

    /**
     * @param LargeAreaRequest $request
     * @return JsonResponse
     */
    public function createLargeArea(LargeAreaRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->largeAreaServices->createLargeArea($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param LargeAreaRequest $request
     * @return JsonResponse
     */
    public function updateLargeArea(LargeAreaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->largeAreaServices->updateLargeArea($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteLargeArea(int $id): JsonResponse
    {
        $data = $this->largeAreaServices->deleteLargeArea($id);

        return response()->json($data, 200);
    }
}
