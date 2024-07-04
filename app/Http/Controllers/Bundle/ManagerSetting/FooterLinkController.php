<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ApiServices;
use App\Services\FooterLinkServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class FooterLinkController extends Controller
{
    protected ApiServices $apiServices;
    protected FooterLinkServices $footerLinkServices;

    public function __construct(
        ApiServices        $apiServices,
        FooterLinkServices $footerLinkServices
    )
    {
        $this->apiServices = $apiServices;
        $this->footerLinkServices = $footerLinkServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createCategoryFooterLink(Request $request): JsonResponse
    {
        $credentials = $request->only('name');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->footerLinkServices->createFooterLinkCategory($request->input());
        return response()->json($result, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCategoryFooterLink($id, Request $request): JsonResponse
    {
        $credentials = $request->only('name');
        //valid credential
        $validator = Validator::make($credentials, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->footerLinkServices->updateFooterLinkCategory($id, $request->input());
        return response()->json($result, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListCategoryFooterLink(): JsonResponse
    {
        $result = $this->footerLinkServices->getListCategoryFooterLink();
        return response()->json($result, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDetailCategoryFooterLink($id): JsonResponse
    {
        $result = $this->footerLinkServices->getDetailCategoryFooterLink($id);
        return response()->json($result, 200);
    }


    /**
     * @param $idCategory
     * @return JsonResponse
     */
    public function deleteCategoryFooterLink($idCategory): JsonResponse
    {
        $result = $this->footerLinkServices->deleteCategoryFooterLink($idCategory);
        return response()->json($result, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createFooterLink(Request $request): JsonResponse
    {
        $credentials = $request->only('link', 'title', 'category_id', 'status', 'target_person', 'link_destination', 'tracking_category', 'tracking_label');
        //valid credential
        $validator = Validator::make($credentials, [
            'link' => 'required|string',
            'title' => 'required|string',
            'category_id' => 'required|int',
            'status' => 'required|int',
            'target_person' => 'required|int',
            'link_destination' => 'required|int',
            'tracking_category' => 'nullable|string',
            'tracking_label' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->footerLinkServices->createFooterLink($request->input());
        return response()->json($result, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateFooterLink($id, Request $request): JsonResponse
    {
        $credentials = $request->only('link', 'title', 'category_id', 'status', 'target_person', 'link_destination', 'tracking_category', 'tracking_label');
        //valid credential
        $validator = Validator::make($credentials, [
            'link' => 'nullable|string',
            'title' => 'nullable|string',
            'category_id' => 'nullable|int',
            'status' => 'nullable|int',
            'target_person' => 'nullable|int',
            'link_destination' => 'nullable|int',
            'tracking_category' => 'nullable|string',
            'tracking_label' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->footerLinkServices->updateFooterLink($id, $request->input());
        return response()->json($result, 200);
    }

    public function getListFooterLinkByCategory($categoryId): JsonResponse
    {
        $result = $this->footerLinkServices->getListFooterLinkByCategory($categoryId);
        return response()->json($result, 200);
    }

    public function getDetailFooterLink($id): JsonResponse
    {
        $result = $this->footerLinkServices->getDetailFooterLink($id);
        return response()->json($result, 200);
    }

    public function deleteFooterLink($id): JsonResponse
    {
        $result = $this->footerLinkServices->deleteFooterLink($id);
        return response()->json($result, 200);
    }
}

