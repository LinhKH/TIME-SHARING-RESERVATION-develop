<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CouponServices;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CouponController extends Controller
{
    protected CouponServices $couponServices;
    protected ApiServices $apiServices;

    public function __construct(
        CouponServices $couponServices,
        ApiServices    $apiServices
    )
    {
        $this->couponServices = $couponServices;
        $this->apiServices = $apiServices;
    }

    public function createCoupon(Request $request): JsonResponse
    {
        $credentials = $request->only('name', 'enabled', 'code', 'number_of_people', 'discount_percentage', 'usable_from', 'usable_to', 'valid_to', 'valid_from', 'space_ids', 'plan_ids', 'memo', 'mail_text', 'days_of_the_week');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'required|string',
            'enabled' => 'required|int',
            'code' => 'required|string',
            'number_of_people' => 'nullable|int',
            'usable_from' => 'nullable|int',
            'usable_to' => 'nullable|int',
            'valid_to' => 'nullable|int',
            'valid_from' => 'nullable|int',
            'space_ids' => 'nullable|string',
            'plan_ids' => 'nullable|string',
            'memo' => 'nullable|string',
            'mail_text' => 'nullable|string',
            'days_of_the_week' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->couponServices->createCoupon($request->input());
        return response()->json($dataResult, 200);
    }

    public function updateCoupon($id, Request $request): JsonResponse
    {
        $credentials = $request->only('name', 'enabled', 'code', 'number_of_people', 'discount_percentage', 'usable_from', 'usable_to', 'valid_to', 'valid_from', 'space_ids', 'plan_ids', 'memo', 'mail_text', 'days_of_the_week');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'nullable|string',
            'enabled' => 'nullable|int',
            'code' => 'nullable|string',
            'number_of_people' => 'nullable|int',
            'usable_from' => 'nullable|int',
            'usable_to' => 'nullable|int',
            'valid_to' => 'nullable|int',
            'valid_from' => 'nullable|int',
            'space_ids' => 'nullable|string',
            'plan_ids' => 'nullable|string',
            'memo' => 'nullable|string',
            'mail_text' => 'nullable|string',
            'days_of_the_week' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->couponServices->updateCoupon($id, $request->input());
        return response()->json($dataResult, 200);
    }

    public function test()
    {
        dd(1);
    }

    public function getDetailCoupon($id): JsonResponse
    {
        $dataResult = $this->couponServices->getDetailCoupon($id);
        return response()->json($dataResult, 200);
    }

    public function getListCoupon(): JsonResponse
    {
        $dataResult = $this->couponServices->getListCoupon();
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $dataResult = $this->couponServices->delete($id);
        return response()->json($dataResult, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handleFilterCoupon(Request $request): JsonResponse
    {
        $data = $this->couponServices->handleFilterCoupon($request);

        return response()->json($data, 200);
    }
}

