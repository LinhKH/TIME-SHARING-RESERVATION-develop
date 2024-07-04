<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Services\Ts\NewsServices;
use App\Services\ApiServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    protected NewsServices $newsServices;
    protected ApiServices $apiServices;

    public function __construct(NewsServices $newsServices, ApiServices $apiServices)
    {
        $this->newsServices = $newsServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function createNews(Request $request): JsonResponse
    {
        $credentials = $request->only('status', 'title', 'description');
        //valid credential
        $validator = Validator::make($credentials, [
            'status' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $data = $request->input();
        $res = $this->newsServices->createNews($data);
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updateNews($id, Request $request): JsonResponse
    {
        $data = $request->input();
        $res = $this->newsServices->updateNews($id, $data);
        return response()->json($res, 200);

    }

    /**
     * @return JsonResponse
     */
    public function getListNews(): JsonResponse
    {
        $res = $this->newsServices->getListNews();
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function getDetailNews($id): JsonResponse
    {
        $res = $this->newsServices->getDetail($id);
        return response()->json($res, 200);
    }

}
