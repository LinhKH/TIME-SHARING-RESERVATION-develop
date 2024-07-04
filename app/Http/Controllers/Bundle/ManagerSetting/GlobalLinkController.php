<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ApiServices;
use App\Services\TrackLinkServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class GlobalLinkController extends Controller
{
    protected ApiServices $apiServices;
    protected TrackLinkServices $linkServices;

    public function __construct(
        ApiServices       $apiServices,
        TrackLinkServices $linkServices
    )
    {
        $this->apiServices = $apiServices;
        $this->linkServices = $linkServices;
    }

    public function creatGlobalLink(Request $request): JsonResponse
    {
        $credentials = $request->only('name');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->linkServices->createGlobalTrackLink($request->input('name'));
        return response()->json($dataResult, 200);
    }


    public function update($id, Request $request): JsonResponse
    {
        $credentials = $request->only('name');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->linkServices->updateNameGlobalLink($id, $request->input('name'));
        return response()->json($dataResult, 200);
    }


    public function getDetailGlobalLink($id, Request $request): JsonResponse
    {
        $dataResult = $this->linkServices->getDetailGlobalLink($id);
        return response()->json($dataResult, 200);
    }


    public function getListGlobalLink(): JsonResponse
    {
        $dataResult = $this->linkServices->getListGlobalLink();
        return response()->json($dataResult, 200);
    }

}

