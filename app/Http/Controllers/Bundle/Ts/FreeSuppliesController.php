<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\FreeSuppliesCreateRequest;
use App\Http\Requests\Ts\FreeSuppliesUpdateRequest;
use App\Services\Ts\FreeSuppliesServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FreeSuppliesController extends Controller
{
    private FreeSuppliesServices $freeSuppliesServices;

    public function __construct(FreeSuppliesServices $freeSuppliesServices)
    {
        $this->middleware('auth:api', ['except' => ['getListFreeSupplies', 'getDetailFreeSupplies']]);
        $this->freeSuppliesServices = $freeSuppliesServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListFreeSupplies(Request $request): JsonResponse
    {
        $data = $this->freeSuppliesServices->getListFreeSupplies($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailFreeSupplies(int $id): JsonResponse
    {
        $data = $this->freeSuppliesServices->getDetailFreeSupplies($id);

        return response()->json($data, 200);
    }

    /**
     * @param FreeSuppliesCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createFreeSupplies(FreeSuppliesCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->freeSuppliesServices->createFreeSupplies($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param FreeSuppliesUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateFreeSupplies(FreeSuppliesUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->freeSuppliesServices->updateFreeSupplies($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteFreeSupplies(int $id): JsonResponse
    {
        $data = $this->freeSuppliesServices->deleteFreeSupplies($id);

        return response()->json($data, 200);
    }
}
