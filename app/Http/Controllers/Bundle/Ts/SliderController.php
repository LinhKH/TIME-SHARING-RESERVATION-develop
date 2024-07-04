<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Services\Ts\SliderServices;
use App\Services\ApiServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    protected SliderServices $sliderServices;
    protected ApiServices $apiServices;

    public function __construct(SliderServices $sliderServices, ApiServices $apiServices)
    {
        $this->sliderServices = $sliderServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function createSlider(Request $request): JsonResponse
    {
        $credentials = $request->only('title');
        //valid credential
        $validator = Validator::make($credentials, [
            'title' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $data = $request->input();
        $res = $this->sliderServices->createSlider($data);
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updateSlider($id, Request $request): JsonResponse
    {
        $data = $request->input();
        $res = $this->sliderServices->updateSlider($id, $data);
        return response()->json($res, 200);

    }

    /**
     * @return JsonResponse
     */
    public function getListSlider(): JsonResponse
    {
        $res = $this->sliderServices->getListSlider();
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function getDetailSlider($id): JsonResponse
    {
        $res = $this->sliderServices->getDetailSlider($id);
        return response()->json($res, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function deleteSlider(Request $request): JsonResponse
    {
        $credentials = $request->only('ids');
        //valid credential
        $validator = Validator::make($credentials, [
            'ids' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $ids = $request->input('ids');
        $res = $this->sliderServices->deleteByIds($ids);
        return response()->json($res, 200);
    }

}
