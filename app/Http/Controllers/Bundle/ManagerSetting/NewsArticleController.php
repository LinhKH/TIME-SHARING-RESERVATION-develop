<?php

namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\NewsArticleServices;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class NewsArticleController extends Controller
{
    protected NewsArticleServices $newsServices;
    protected ApiServices $apiServices;

    public function __construct(
        NewsArticleServices $newsServices,
        ApiServices         $apiServices
    )
    {
        $this->newsServices = $newsServices;
        $this->apiServices = $apiServices;
    }

    public function createNewsArticle(Request $request): JsonResponse
    {
        $credentials = $request->only('active', 'attribute');
        //valid credential
        $validator = Validator::make($credentials, [
            'attribute' => 'required',
            'active' => 'required|int',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->newsServices->CreateNews($request->input());
        return response()->json($dataResult, 200);
    }

    public function updateNewsArticle($newsId, Request $request): JsonResponse
    {
        $dataResult = $this->newsServices->updateNews($newsId, $request->input());
        return response()->json($dataResult, 200);
    }

    public function getListNews(): JsonResponse
    {
        $listNews = $this->newsServices->getListNews();
        return response()->json($listNews, 200);
    }

    public function getNewsDetail($newsId): JsonResponse
    {
        $newsDetail = $this->newsServices->getNewsDetail($newsId);
        return response()->json($newsDetail, 200);
    }

    public function deleteNews($id): JsonResponse
    {
        $result = $this->newsServices->deleteNews($id);
        return response()->json($result, 200);
    }

}
