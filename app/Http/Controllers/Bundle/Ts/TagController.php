<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\TagCreateRequest;
use App\Http\Requests\Ts\TagUpdateRequest;
use App\Services\Ts\TagServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagServices $tagServices;

    public function __construct(TagServices $tagServices)
    {
        $this->middleware('auth:api', ['except' => ['getListTag', 'getDetailTag']]);
        $this->tagServices = $tagServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListTag(Request $request): JsonResponse
    {
        $data = $this->tagServices->getListTag($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getDetailTag(int $id): JsonResponse
    {
        $data = $this->tagServices->getDetailTag($id);

        return response()->json($data, 200);
    }

    /**
     * @param TagCreateRequest $request
     *
     * @return JsonResponse
     */
    public function createTag(TagCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->tagServices->createTag($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param TagUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateTag(TagUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->tagServices->updateTag($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteTag(int $id): JsonResponse
    {
        $data = $this->tagServices->deleteTag($id);

        return response()->json($data, 200);
    }
}
