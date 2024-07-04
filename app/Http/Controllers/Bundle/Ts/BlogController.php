<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Services\Ts\BlogServices;
use App\Services\ApiServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    protected BlogServices $blogServices;
    protected ApiServices $apiServices;

    public function __construct(BlogServices $blogServices, ApiServices $apiServices)
    {
        $this->blogServices = $blogServices;
        $this->apiServices = $apiServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createBlog(Request $request): JsonResponse
    {
        $credentials = $request->only('description', 'suggestions', 'type_id', 'tag');
        //valid credential
        $validator = Validator::make($credentials, [
            'description' => 'required|string',
            'suggestions' => 'required|array',
            'type_id' => 'required|int',
            'tag' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $data = $request->input();
        $res = $this->blogServices->createBlog($data);
        return response()->json($res, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateBlog(Request $request, $id): JsonResponse
    {

        $data = $request->input();
        $res = $this->blogServices->updateBlog($data, $id);
        return response()->json($res, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListBlog(): JsonResponse
    {
        $res = $this->blogServices->getListBlog();
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDetailBlog($id): JsonResponse
    {
        $res = $this->blogServices->getDetailBlog($id);
        return response()->json($res, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createBlogType(Request $request): JsonResponse
    {
        $data = $request->input();
        $res = $this->blogServices->createBlogType($data);
        return response()->json($res, 200);
    }

    public function updateBlogType($id, Request $request): JsonResponse
    {
        $data = $request->input();
        $res = $this->blogServices->updateBlogType($id, $data);
        return response()->json($res, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListBlogType(): JsonResponse
    {
        $res = $this->blogServices->getListBlogType();
        return response()->json($res, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDetailBlogType($id): JsonResponse
    {
        $res = $this->blogServices->getDetailBlogType($id);
        return response()->json($res, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteBlogType(Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        $res = $this->blogServices->deleteBlogType($ids);
        return response()->json($res, 200);
    }
}
