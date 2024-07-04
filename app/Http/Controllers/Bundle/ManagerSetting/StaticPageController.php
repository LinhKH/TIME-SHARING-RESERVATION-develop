<?php

namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\StaticPageServices;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class StaticPageController extends Controller
{
    protected StaticPageServices $staticPageServices;
    protected ApiServices $apiServices;

    public function __construct(
        StaticPageServices $staticPageServices,
        ApiServices        $apiServices
    )
    {
        $this->staticPageServices = $staticPageServices;
        $this->apiServices = $apiServices;
    }

    public function createStaticPageArticle(Request $request): JsonResponse
    {
        $credentials = $request->only('attribute');
        //valid credential
        $validator = Validator::make($credentials, [
            'attribute' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->staticPageServices->createStaticPageArticle($request->input());
        return response()->json($dataResult, 200);
    }

    public function updateStaticPageArticle($pageId, Request $request): JsonResponse
    {
        $dataResult = $this->staticPageServices->updateStaticPageArticle($pageId, $request->input());
        return response()->json($dataResult, 200);
    }

    public function getListStaticPage(): JsonResponse
    {
        $listStaticPage = $this->staticPageServices->getListStaticPage();
        return response()->json($listStaticPage, 200);
    }

    public function deleteStaticPage($id): JsonResponse
    {
        $result = $this->staticPageServices->deleteStaticPage($id);
        return response()->json($result, 200);
    }

    public function getDetail($id): JsonResponse
    {
        $result = $this->staticPageServices->getDetail($id);
        return response()->json($result, 200);
    }

}
