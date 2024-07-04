<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\EquipmentCategoriesCreateRequest;
use App\Http\Requests\Ts\EquipmentCategoriesUpdateRequest;
use App\Services\Ts\EquipmentCategoriesServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentCategoriesController extends Controller
{
    private EquipmentCategoriesServices $municipalitisServices;

    public function __construct(EquipmentCategoriesServices $municipalitisServices)
    {
        $this->middleware('auth:api', ['except' => ['getListEquipmentCategories', 'getDetailEquipmentCategories']]);
        $this->municipalitisServices = $municipalitisServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListEquipmentCategories(Request $request): JsonResponse
    {
        $data = $this->municipalitisServices->getListEquipmentCategories($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailEquipmentCategories(int $id): JsonResponse
    {
        $data = $this->municipalitisServices->getDetailEquipmentCategories($id);

        return response()->json($data, 200);
    }

    /**
     * @param EquipmentCategoriesCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createEquipmentCategories(EquipmentCategoriesCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->municipalitisServices->createEquipmentCategories($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param EquipmentCategoriesUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateEquipmentCategories(EquipmentCategoriesUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->municipalitisServices->updateEquipmentCategories($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteEquipmentCategories(int $id): JsonResponse
    {
        $data = $this->municipalitisServices->deleteEquipmentCategories($id);

        return response()->json($data, 200);
    }
}
