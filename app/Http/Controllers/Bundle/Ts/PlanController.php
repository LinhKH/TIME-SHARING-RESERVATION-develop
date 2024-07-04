<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\PlanCreateRequest;
use App\Http\Requests\Ts\PlanUpdateRequest;
use App\Services\Ts\PlanServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    private PlanServices $planServices;

    public function __construct(PlanServices $planServices)
    {
        $this->middleware('auth:api', ['except' => ['getListPlan', 'getDetailPlan']]);
        $this->planServices = $planServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListPlan(Request $request): JsonResponse
    {
        $data = $this->planServices->getListPlan($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailPlan(int $id): JsonResponse
    {
        $data = $this->planServices->getDetailPlan($id);

        return response()->json($data, 200);
    }

    /**
     * @param PlanCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createPlan(PlanCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->planServices->createPlan($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param PlanUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updatePlan(PlanUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->planServices->updatePlan($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deletePlan(int $id): JsonResponse
    {
        $data = $this->planServices->deletePlan($id);

        return response()->json($data, 200);
    }
}
