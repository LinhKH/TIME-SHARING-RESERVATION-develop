<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use App\Services\CommonConstant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\EquipmentInformationServices;
use App\Services\ImportCsvHoliday;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class EquipmentInformationController extends Controller
{
    protected EquipmentInformationServices $equipmentInformationServices;
    protected ApiServices $apiServices;

    public function __construct(
        EquipmentInformationServices $equipmentInformationServices,
        ApiServices                  $apiServices
    )
    {
        $this->equipmentInformationServices = $equipmentInformationServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param $categoryId
     * @param Request $request
     * @return JsonResponse
     */

    public function createEquipmentInformation($categoryId, Request $request): JsonResponse
    {
        $credentials = $request->only('active', 'checkbox_label_type', 'default_value', 'frequently_used', 'legacy_id', 'parent_id', 'required', 'string_id', 'attribute');
        //valid credential
        $validator = Validator::make($credentials, [
            'active' => 'required|int',
            'required' => 'required|int',
            'checkbox_label_type' => 'required|int',
            'string_id' => 'required|string',
            'frequently_used' => 'required|int',
            'default_value' => 'nullable|int',
            'legacy_id' => 'nullable|int',
            'parent_id' => 'nullable|string',
            'attribute' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->equipmentInformationServices->createEquipmentInformation($categoryId, $request->input());
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updateEquipmentInformation($id, Request $request): JsonResponse
    {
        $credentials = $request->only('active', 'checkbox_label_type', 'default_value', 'frequently_used', 'legacy_id', 'parent_id', 'required', 'attribute');
        //valid credential
        $validator = Validator::make($credentials, [
            'active' => 'required|int',
            'required' => 'required|int',
            'checkbox_label_type' => 'required|int',
            'frequently_used' => 'required|int',
            'default_value' => 'nullable|int',
            'legacy_id' => 'nullable|int',
            'parent_id' => 'nullable|string',
            'attribute' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $dataResult = $this->equipmentInformationServices->updateEquipmentInformation($id, $request->input());
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function getDetail($id): JsonResponse
    {
        $dataResult = $this->equipmentInformationServices->getDetailEquipmentInformation($id);
        return response()->json($dataResult, 200);
    }

    /**
     * @param $category
     * @return JsonResponse
     */
    public function getListEquipmentInformationByCategory($category): JsonResponse
    {
        $dataResult = $this->equipmentInformationServices->getListByCategory($category);
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */

    public function delete($id): JsonResponse
    {
        $dataResult = $this->equipmentInformationServices->deleteEquipmentInformation($id);
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function uploadImageEquipmentInformation($id, Request $request): JsonResponse
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
        $dataResult = $this->equipmentInformationServices->uploadImageEquipmentInformation($id, $request->file('file'), $request->input('type'));
        return response()->json($dataResult, 200);
    }


    /**
     * @return JsonResponse
     */
    public function getListEquipment(): JsonResponse
    {
        $dataResult = $this->equipmentInformationServices->getListEquipment();
        return response()->json($dataResult, 200);
    }

    public function deleteImgEquipment($id): JsonResponse
    {
        $dataResult = $this->equipmentInformationServices->deleteImgEquipmentInformation($id);
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

}

