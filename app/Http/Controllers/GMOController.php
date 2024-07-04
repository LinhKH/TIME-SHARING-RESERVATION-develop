<?php

namespace App\Http\Controllers;

use App\Services\ApiServices;
use App\Services\GMOServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;


class GMOController extends Controller
{

    protected GMOServices $GMOServices;
    protected ApiServices $apiServices;

    public function __construct(GMOServices $GMOServices, ApiServices $apiServices)
    {
        $this->GMOServices = $GMOServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function entryTranGMO(Request $request): JsonResponse
    {
        $credentials = $request->only('OrderID', 'Amount');
        //valid credential
        $validator = \Illuminate\Support\Facades\Validator::make($credentials, [
            'OrderID' => 'required|string',
            'Amount' => 'required|int',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataString = "ShopID=" . config('app.shop_id') . "&ShopPass=" . config('app.shop_pass') . "&OrderID=" . $request->input('OrderID') . "&JobCd=" . config('app.jobcd') . "&Amount=" . $request->input('Amount');

        $result = $this->GMOServices->GMOEnTryTran($dataString,$request->input('OrderID'));
        return response()->json($result, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execTranGMO(Request $request): JsonResponse
    {
        $credentials = $request->only('AccessID', 'AccessPass', 'OrderID', 'Method', 'CardNo', 'Expire');
        //valid credential
        $validator = \Illuminate\Support\Facades\Validator::make($credentials, [
            'AccessID' => 'required|string',
            'AccessPass' => 'required|string',
            'OrderID' => 'required|string',
            'Method' => 'required|string',
            'CardNo' => 'required|string',
            'Expire' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }

        $dataString = "AccessID=" . $request->input('AccessID') . "&AccessPass=" . $request->input('AccessPass') . "&OrderID=" . $request->input('OrderID') . "&Method=" . $request->input('Method') . "&CardNo=" . $request->input('CardNo') . "&Expire=" . $request->input('Expire');
        $result = $this->GMOServices->GMOExecTran($dataString);
        return response()->json($result, 200);
    }
}
