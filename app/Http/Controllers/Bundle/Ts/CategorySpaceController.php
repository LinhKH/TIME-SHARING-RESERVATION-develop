<?php

namespace App\Http\Controllers\Bundle\Ts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ts\CategorySpaceCreateRequest;
use App\Http\Requests\Ts\CategorySpaceUpdateRequest;
use App\Services\Ts\CategorySpaceServices;
use Illuminate\Http\JsonResponse;

class CategorySpaceController extends Controller
{
    private CategorySpaceServices $categorySpaceServices;

    public function __construct(CategorySpaceServices $categorySpaceServices)
    {
        $this->middleware('auth:api', ['except' => ['getListCategorySpaces', 'getDetailCategorySpaces']]);
        $this->categorySpaceServices = $categorySpaceServices;
    }

    /**
     * @return JsonResponse
     */
    public function getListCategorySpaces(): JsonResponse
    {
        $data = $this->categorySpaceServices->getListCategorySpaces();

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDetailCategorySpaces(int $id): JsonResponse
    {
        $data = $this->categorySpaceServices->getDetailCategorySpaces($id);

        return response()->json($data, 200);
    }

    /**
     * @param CategorySpaceCreateRequest $request
     * @return JsonResponse
     */
    public function createCategorySpaces(CategorySpaceCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->categorySpaceServices->createCategorySpaces($data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @param CategorySpaceUpdateRequest $request
     * @return JsonResponse
     */
    public function updateCategorySpaces(CategorySpaceUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $res = $this->categorySpaceServices->updateCategorySpaces($id, $data);

        return response()->json($res, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteCategorySpaces(int $id): JsonResponse
    {
        $data = $this->categorySpaceServices->deleteCategorySpaces($id);

        return response()->json($data, 200);
    }
}
