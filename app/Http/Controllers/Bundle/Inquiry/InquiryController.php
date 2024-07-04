<?php

namespace App\Http\Controllers\Bundle\Inquiry;

use App\Exports\InquiryExport;
use App\Services\InquiryServices;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryReplyRequest;
use App\Http\Requests\InquiryRequest;
use App\Http\Requests\InquirySpaceCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    protected InquiryServices $inquiryServices;
    protected ApiServices $apiServices;

    public function __construct(InquiryServices $inquiryServices, ApiServices $apiServices)
    {
        $this->inquiryServices = $inquiryServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param InquiryRequest $request
     * @return JsonResponse
     */
    public function getListInquiryByProduct(Request $request): JsonResponse
    {
        $data = $this->inquiryServices->getListInquiryByProduct($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDetailInquiry(int $id): JsonResponse
    {
        $data = $this->inquiryServices->getDetailInquiry($id);

        return response()->json($data, 200);
    }

    /**
     * @param InquiryRequest $request
     * @return JsonResponse
     */
    public function createInquiry(InquiryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->inquiryServices->createInquiry($data);

        return response()->json($res, 200);
    }


    /**
     * @param InquirySpaceCreateRequest $request
     * @param int $spaceId
     *
     * @return JsonResponse
     */
    public function createInquirySpace(InquirySpaceCreateRequest $request, int $spaceId): JsonResponse
    {
        $data = $request->validated();
        $res = $this->inquiryServices->createInquirySpace($data, $spaceId);

        return response()->json($res, 200);
    }

    /**
     * @param InquiryReplyRequest $request
     * @param int $inquiryId
     *
     * @return JsonResponse
     */
    public function handleInquiryReply(InquiryReplyRequest $request, int $inquiryId): JsonResponse
    {
        $data = $request->validated();
        $res = $this->inquiryServices->handleInquiryReply($data, $inquiryId);
        $this->inquiryServices->updateStatusInquiry(0, $inquiryId);

        return response()->json($res, 200);
    }

    /**
     * handleExportInquiry
     */
    public function handleExportInquiry()
    {
        return $this->inquiryServices->handleExportInquiry();
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function getListInquiryReply($id): JsonResponse
    {
        $res = $this->inquiryServices->getListInquiryReply($id);

        return response()->json($res, 200);
    }

    /**
     * @param int $spaceId
     *
     * @return JsonResponse
     */
    public function getListReplySpace(int $spaceId): JsonResponse
    {
        $res = $this->inquiryServices->getListReplySpace($spaceId);

        return response()->json($res, 200);
    }


    public function updateStatusInquiry(Request $request, $id): JsonResponse
    {
        $credentials = $request->only('support_done');
        //valid credential
        $validator = Validator::make($credentials, [
            'support_done' => 'required|int',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }

        $res = $this->inquiryServices->updateStatusInquiry($request->input('support_done'), $id);
        return response()->json($res, 200);
    }

    public function updateIsRead(Request $request, $id): JsonResponse
    {
        $credentials = $request->only('is_read');
        //valid credential
        $validator = Validator::make($credentials, [
            'is_read' => 'required|int',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }

        $res = $this->inquiryServices->updateIsReadInquiry($request->input('is_read'), $id);
        return response()->json($res, 200);
    }
}
