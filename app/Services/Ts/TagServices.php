<?php

namespace App\Services\Ts;

use App\Repositories\Ts\TagRepository;
use App\Services\CommonConstant;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TagServices
{
    protected TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListTag($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->tagRepository->getListTag($filter, CommonConstant::PAGINATE_LIMIT_EQUIPMENT_CATEGORY_WP);

            return [
                'status' => Response::HTTP_OK,
                'data' => $data
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
     * @param int $id
     *
     * @return array
     */
    public function getDetailTag(int $id): array
    {
        $this->tagRepository->findOneById($id);

        try {
            $data = $this->tagRepository->getDetailTag($id);

            return [
                'status' => Response::HTTP_OK,
                'data' => $data
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
     * @param $dataCreate
     *
     * @return array
     */
    public function createTag($dataCreate): array
    {
        try {
            if (empty($dataCreate['slug'])) {
                $dataCreate['slug'] = $dataCreate['name'];
            }

            $result = $this->tagRepository->create($dataCreate);

            return $this->getTagEntity($result->id);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     * @param array $dataUpdate
     *
     * @return array
     */
    public function updateTag(int $id, array $dataUpdate): array
    {
        $this->tagRepository->findOneById($id);

        try {
            if (isset($dataUpdate['name'])) {
                $checkName = $this->tagRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->tagRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->tagRepository->updateOneById($id, $dataUpdate);

            return $this->getTagEntity($id);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function deleteTag(int $id): array
    {
        $this->tagRepository->findOneById($id);

        try {
            $this->tagRepository->deleteOneById($id);

            return [
                'id' => $id,
                'status' => Response::HTTP_OK,
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
     * @param int $id
     *
     * @return array
     */
    public function getTagEntity(int $id): array
    {
        $data = $this->tagRepository->findOneById($id);

        return [
            'status' => Response::HTTP_OK,
            'data' => $data->toArray()
        ];
    }
}
