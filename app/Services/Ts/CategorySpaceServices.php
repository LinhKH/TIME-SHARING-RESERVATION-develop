<?php

namespace App\Services\Ts;

use App\Repositories\Ts\CategorySpaceRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CategorySpaceServices
{
    protected CategorySpaceRepository $categorySpaceRepository;

    public function __construct(CategorySpaceRepository $categorySpaceRepository)
    {
        $this->categorySpaceRepository = $categorySpaceRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListCategorySpaces(): array
    {
        try {
            $data = $this->categorySpaceRepository->getListCategorySpaces();

            return [
                'data' => $data,
                'status' => Response::HTTP_OK
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
    public function getDetailCategorySpaces(int $id): array
    {
        $this->categorySpaceRepository->findOneById($id);

        try {
            $data = $this->categorySpaceRepository->getDetailCategorySpaces($id);

            return [
                'data' => $data,
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
     * @param $dataCreate
     *
     * @return array
     */
    public function createCategorySpaces($dataCreate): array
    {
        try {
            $putFile = Storage::putFile('public/category-spaces', $dataCreate['file'], 'public');
            $dataCreate['file'] = Storage::url($putFile);

            $result = $this->categorySpaceRepository->create($dataCreate);

            return $this->getCategorySpacesEntity($result->id);
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
    public function updateCategorySpaces(int $id, array $dataUpdate): array
    {
        $this->categorySpaceRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->categorySpaceRepository->handleCheckNameCategory($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->categorySpaceRepository->handleCheckSlugCategory($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->categorySpaceRepository->updateOneById($id, $dataUpdate);

            return $this->getCategorySpacesEntity($id);
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
    public function deleteCategorySpaces(int $id): array
    {
        $this->categorySpaceRepository->findOneById($id);

        try {
            $this->categorySpaceRepository->deleteOneById($id);

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
    public function getCategorySpacesEntity(int $id): array
    {
        $data = $this->categorySpaceRepository->findOneById($id);

        return [
            'data' => $data->toArray(),
            'status' => Response::HTTP_OK
        ];
    }
}
