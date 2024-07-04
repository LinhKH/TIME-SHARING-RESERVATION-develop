<?php

namespace App\Services\Ts;

use App\Services\CommonConstant;
use App\Services\ApiServices;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Ts\TagRepository;
use App\Repositories\BlogItem\BlogItemRepository;
use App\Repositories\BlogType\BlogTypeRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BlogServices
{
    protected TagRepository $tagRepository;

    protected ApiServices $apiServices;
    protected BlogRepository $blogRepository;
    protected BlogItemRepository $blogItemRepository;
    protected BlogTypeRepository $blogTypeRepository;

    public function __construct(ApiServices $apiServices, BlogRepository $blogRepository, BlogItemRepository $blogItemRepository, BlogTypeRepository $blogTypeRepository, TagRepository $tagRepository)
    {
        $this->apiServices = $apiServices;
        $this->blogRepository = $blogRepository;
        $this->blogItemRepository = $blogItemRepository;
        $this->blogTypeRepository = $blogTypeRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param $data
     * @return array
     */
    public function createBlog($data): array
    {
        try {
            $blogData = [
                'title' => $data['title'] ?? null,
                'description' => $data['description']??null,
                'suggestions' => json_encode($data['suggestions']),
                'type_id' => $data['type_id'],
                'tag' => json_encode($data['tag'])
            ];
            $blogItem = $data['item'] ?? [];
            DB::beginTransaction();
            $blog = $this->blogRepository->create($blogData);
            foreach ($blogItem as $item) {
                $item['blog_id'] = $blog->id;
                $this->blogItemRepository->create($item);
            }
            $data['id'] = $blog->id;
            DB::commit();
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $data
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $data
     * @param $id
     * @return array
     */
    public function updateBlog($data, $id): array
    {
        try {
            DB::beginTransaction();

            $blogUpdate = [
                'title' => $data['title'] ?? null,
                'suggestions' => json_encode($data['suggestions']),
                'type_id' => $data['type_id'],
                'tag' => json_encode($data['tag'])
            ];
            $this->blogRepository->updateOneById($id, $blogUpdate);
            $blogItem = $data['item'] ?? [];
            $this->blogItemRepository->deleteManyBy('blog_id', $id);
            foreach ($blogItem as $item) {
                $item['blog_id'] = $id;
                $this->blogItemRepository->create($item);
            }
            DB::commit();
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $data
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function getDetailBlog($id): array
    {
        try {
            $dataResult = $this->blogRepository->findOneBy('id', $id);
            if (empty($dataResult)) {
                return [
                    'status' => CommonConstant::ERROR_CODE,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $dataResult['tag'] = $this->tagRepository->findManyByIds(json_decode($dataResult['tag']));
            $dataResult['suggestions'] = $this->blogRepository->findManyByIds(json_decode($dataResult['suggestions']));
            $dataResult['item'] = $this->blogItemRepository->findManyBy('blog_id', $id);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $dataResult
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @return array
     */
    public function getListBlog(): array
    {
        try {
            $data = $this->blogRepository->paginate(CommonConstant::PER_PAGE);
            $dataResult['data'] = $data['data'] ?? [];
            $dataResult['paginate'] = $this->apiServices->getPaginate($data);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $dataResult
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    /**
     * @param $data
     * @return array
     */
    public function createBlogType($data): array
    {
        if (empty($data)) {
            return [
                'status' => CommonConstant::ERROR_CODE,
                'msg' => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }
        $dataInsert = [
            "name" => $data['name'] ?? null,
            "slug" => $data['slug'] ?? null,
            "description" => $data['description'] ?? null,
        ];
        $blogType = $this->blogTypeRepository->create($dataInsert);
        return [
            'status' => CommonConstant::SUCCESS_CODE,
            'msg' => CommonConstant::MSG_SUCCESSFUL,
            "result" => $blogType
        ];
    }


    public function updateBlogType($id, $data): array
    {
        $isCheck = $this->blogTypeRepository->findOneBy('id', $id);
        if (empty($data) || empty($isCheck)) {
            return [
                'status' => CommonConstant::ERROR_CODE,
                'msg' => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }
        $blogType = $this->blogTypeRepository->updateOneById($id, $data);
        return [
            'status' => CommonConstant::SUCCESS_CODE,
            'msg' => CommonConstant::MSG_SUCCESSFUL,
            "result" => $blogType
        ];
    }

    /**
     * @return array
     */
    public function getListBlogType(): array
    {
        try {
            $data = $this->blogTypeRepository->paginate(CommonConstant::LIMIT_PAGE);
            $dataResult['data'] = $data['data'] ?? [];
            $dataResult['paginate'] = $this->apiServices->getPaginate($data);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $dataResult
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function getDetailBlogType($id): array
    {
        try {
            $data = $this->blogTypeRepository->findOneBy('id', $id);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteBlogType($ids): array
    {
        try {
            foreach ($ids as $id) {
                $isCheck = $this->blogTypeRepository->findOneBy('id', $id);
                if (empty($isCheck)) {
                    continue;
                }
                $this->blogTypeRepository->deleteOneById($id);
            }
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $ids
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

}
