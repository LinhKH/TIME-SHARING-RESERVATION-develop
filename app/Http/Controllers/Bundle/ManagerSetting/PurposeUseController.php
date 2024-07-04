<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use App\Services\CommonConstant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\PurposeUseServices;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class PurposeUseController extends Controller
{
    protected PurposeUseServices $purposeUseServices;
    protected ApiServices $apiServices;

    public function __construct(
        PurposeUseServices $purposeUseServices,
        ApiServices        $apiServices
    ) {
        $this->purposeUseServices = $purposeUseServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param $categoryId
     * @param Request $request
     * @return JsonResponse
     */

    public function createPurposeUse($categoryId, Request $request): JsonResponse
    {
        $credentials = $request->only('active', 'equipment_information_icons_ids', 'equipment_information_ids', 'equipment_information_ids_mobile');
        //valid credential
        $validator = Validator::make($credentials, [
            'active' => 'required|int',
            'equipment_information_icons_ids' => 'nullable|array',
            'equipment_information_ids' => 'nullable|array',
            'equipment_information_ids_mobile' => 'nullable|array',
            'attribute' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->purposeUseServices->createPurposeUse($categoryId, $request->input());
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updatePurposeUse($id, Request $request): JsonResponse
    {
        $credentials = $request->only('active', 'equipment_information_icons_ids', 'equipment_information_ids', 'equipment_information_ids_mobile');
        //valid credential
        $validator = Validator::make($credentials, [
            'active' => 'required|int',
            'equipment_information_icons_ids' => 'nullable|array',
            'equipment_information_ids' => 'nullable|array',
            'equipment_information_ids_mobile' => 'nullable|array',
            'attribute' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->purposeUseServices->updatePurposeUse($id, $request->input());
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function getDetail($id): JsonResponse
    {
        $dataResult = $this->purposeUseServices->getDetailPurpose($id);
        return response()->json($dataResult, 200);
    }


    public function getListByCategory($categoryId): JsonResponse
    {
        $dataResult = $this->purposeUseServices->getListByCategory($categoryId);
        return response()->json($dataResult, 200);
    }


    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function uploadImagePurposeUse($id, Request $request): JsonResponse
    {
        if (!$request->has('file')) {
            return response()->json([
                'status' => 400,
                'message' => 'Upload file not found'
            ], 400);
        }
        if (!$request->has('type')) {
            return response()->json([
                'status' => 400,
                'message' => 'Type of image is field require'
            ], 400);
        }
        $dataResult = $this->purposeUseServices->uploadImagePurposeUse($id, $request->file('file'), $request->input('type'));
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updateImgPurpose($id, Request $request): JsonResponse
    {
        if (!$request->has('file')) {
            return response()->json([
                'status' => 400,
                'message' => 'Upload file not found'
            ], 400);
        }
        $dataResult = $this->purposeUseServices->updateImgPurpose($id, $request->file('file'));
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function deleteImgPurpose($id): JsonResponse
    {
        $dataResult = $this->purposeUseServices->deleteImgPurpose($id);
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getListImagePurposeUse($id): JsonResponse
    {
        $dataResult = $this->purposeUseServices->getListImgPurposeUse($id);
        return response()->json($dataResult, 200);
    }


    /**
     * @return JsonResponse
     */
    public function getListCategory(): JsonResponse
    {
        $data = CommonConstant::CATEGORY_EQUIPMENT;
        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListPurposeUse(): JsonResponse
    {
        $dataResult = $this->purposeUseServices->getListPurposeUse();

        return response()->json($dataResult, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deletePurposeUse(int $id): JsonResponse
    {
        $data = $this->purposeUseServices->deletePurposeUse($id);

        return response()->json($data, 200);
    }
}
