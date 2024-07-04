<?php

namespace App\Http\Controllers\Bundle\ManagerSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationCreateRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Services\LocationServices;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    private LocationServices $locationServices;

    public function __construct(LocationServices $locationServices)
    {
        $this->middleware('auth:api', ['except' => ['getListLocation', 'getDetailLocation']]);
        $this->locationServices = $locationServices;
    }

    /**
     * @return JsonResponse
     */
    public function getListLocation(): JsonResponse
    {
        $data = $this->locationServices->getListLocation();

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailLocation(int $id): JsonResponse
    {
        $data = $this->locationServices->getDetailLocation($id);

        return response()->json($data, 200);
    }

    /**
     * @param LocationCreateRequest $request
     * @return JsonResponse
     */
    public function createLocation(LocationCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->locationServices->createLocation($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param LocationUpdateRequest $request
     * @return JsonResponse
     */
    public function updateLocation(LocationUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->locationServices->updateLocation($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteLocation(int $id): JsonResponse
    {
        $data = $this->locationServices->deleteLocation($id);

        return response()->json($data, 200);
    }
}
