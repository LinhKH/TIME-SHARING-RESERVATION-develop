<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\MunicipalitieCreateRequest;
use App\Http\Requests\Ts\MunicipalitieUpdateRequest;
use App\Services\Ts\MunicipalitiServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MunicipalitieController extends Controller
{
    private MunicipalitiServices $municipalitisServices;

    public function __construct(MunicipalitiServices $municipalitisServices)
    {
        $this->middleware('auth:api', ['except' => ['getListMunicipalitie', 'getDetailMunicipalitie']]);
        $this->municipalitisServices = $municipalitisServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListMunicipalitie(Request $request): JsonResponse
    {
        $data = $this->municipalitisServices->getListMunicipalitie($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailMunicipalitie(int $id): JsonResponse
    {
        $data = $this->municipalitisServices->getDetailMunicipalitie($id);

        return response()->json($data, 200);
    }

    /**
     * @param MunicipalitieCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createMunicipalitie(MunicipalitieCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->municipalitisServices->createMunicipalitie($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param MunicipalitieUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateMunicipalitie(MunicipalitieUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->municipalitisServices->updateMunicipalitie($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteMunicipalitie(int $id): JsonResponse
    {
        $data = $this->municipalitisServices->deleteMunicipalitie($id);

        return response()->json($data, 200);
    }
}
