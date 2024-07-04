<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\PaidEquipmentCreateRequest;
use App\Http\Requests\Ts\PaidEquipmentUpdateRequest;
use App\Services\Ts\PaidEquipmentServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaidEquipmentController extends Controller
{
    private PaidEquipmentServices $PaidEquipmentServices;

    public function __construct(PaidEquipmentServices $PaidEquipmentServices)
    {
        $this->middleware('auth:api', ['except' => ['getListPaidEquipment', 'getDetailPaidEquipment']]);
        $this->PaidEquipmentServices = $PaidEquipmentServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListPaidEquipment(Request $request): JsonResponse
    {
        $data = $this->PaidEquipmentServices->getListPaidEquipment($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailPaidEquipment(int $id): JsonResponse
    {
        $data = $this->PaidEquipmentServices->getDetailPaidEquipment($id);

        return response()->json($data, 200);
    }

    /**
     * @param PaidEquipmentCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createPaidEquipment(PaidEquipmentCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->PaidEquipmentServices->createPaidEquipment($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param PaidEquipmentUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updatePaidEquipment(PaidEquipmentUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->PaidEquipmentServices->updatePaidEquipment($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deletePaidEquipment(int $id): JsonResponse
    {
        $data = $this->PaidEquipmentServices->deletePaidEquipment($id);

        return response()->json($data, 200);
    }
}
