<?php

namespace App\Services;

use App\Models\FooterLink;
use App\Models\FooterLinkCategory;
use App\Services\ApiServices;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\FooterLink\FooterLinkRepository;
use App\Repositories\FooterLinkEav\FooterLinkEavRepository;
use App\Repositories\FooterLinkCategory\FooterLinkCategoryRepository;
use App\Repositories\FooterLinkCategoryEav\FooterLinkCategoryEavRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class FooterLinkServices
{
    protected FooterLinkRepository $footerLinkRepository;
    protected FooterLinkEavRepository $footerLinkEavRepository;
    protected FooterLinkCategoryRepository $footerLinkCategoryRepository;
    protected FooterLinkCategoryEavRepository $footerLinkCategoryEavRepository;
    protected ApiServices $apiServices;

    public function __construct(
        FooterLinkRepository            $footerLinkRepository,
        FooterLinkEavRepository         $footerLinkEavRepository,
        FooterLinkCategoryRepository    $footerLinkCategoryRepository,
        FooterLinkCategoryEavRepository $footerLinkCategoryEavRepository,
        ApiServices                     $apiServices

    )
    {
        $this->footerLinkRepository = $footerLinkRepository;
        $this->footerLinkEavRepository = $footerLinkEavRepository;
        $this->footerLinkCategoryRepository = $footerLinkCategoryRepository;
        $this->footerLinkCategoryEavRepository = $footerLinkCategoryEavRepository;
        $this->apiServices = $apiServices;
    }


    public function createFooterLinkCategory($dataInput): array
    {
        try {
            $orderNumber = 1;
            $lastId = FooterLinkCategory::latest()->first();
            if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }
            DB::beginTransaction();
            $footerLinkCategory = [
                'order_number' => $orderNumber
            ];
            $category = $this->footerLinkCategoryRepository->create($footerLinkCategory);

            foreach ($dataInput as $key => $item) {
                $footerLinkCategoryEav = [
                    'namespace' => $category->id,
                    'attribute' => $key,
                    'value' => $item,
                    'type' => \App\Services\CommonConstant::STATUS_ACTIVE
                ];
                $this->footerLinkCategoryEavRepository->create($footerLinkCategoryEav);
            }
            DB::commit();
            $dataInput['id'] = $category->id;
            return $dataInput;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function updateFooterLinkCategory($id, $dataUpdate): array
    {
        try {
            DB::beginTransaction();
            foreach ($dataUpdate as $key => $item) {
                $isCheck = $this->footerLinkCategoryEavRepository->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                $footerLinkCategoryEav = [
                    'namespace' => $id,
                    'attribute' => $key,
                    'value' => $item,
                    'type' => \App\Services\CommonConstant::STATUS_ACTIVE
                ];
                if (!empty($isCheck)) {
                    $this->footerLinkCategoryEavRepository->updateOneByCondition(['namespace' => $id, 'attribute' => $key], $footerLinkCategoryEav);
                } else {
                    $this->footerLinkCategoryEavRepository->create($footerLinkCategoryEav);
                }
            }
            DB::commit();
            $dataUpdate['id'] = $id;
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getListCategoryFooterLink(): array
    {
        try {
            $dataResult = null;
            $listCategory = $this->footerLinkCategoryRepository->findAll();
            if (empty($listCategory)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            foreach ($listCategory->toArray() as $key => $value) {
                $categoryEav = $this->footerLinkCategoryEavRepository->findManyBy('namespace', $value['id']);
                $dataResult['data'][] = array_merge($value, $this->convertData($categoryEav));
            }
            return $dataResult;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function getDetailCategoryFooterLink($id): array
    {
        try {
            $category = $this->footerLinkCategoryRepository->findOneBy('id', $id);
            if (empty($category)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $categoryEav = $this->footerLinkCategoryEavRepository->findManyBy('namespace', $id);
            return array_merge($category->toArray(), $this->convertData($categoryEav));
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function deleteCategoryFooterLink($id): array
    {
        try {
            $category = $this->footerLinkCategoryRepository->findOneBy('id',$id);
            if (empty($category)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->footerLinkCategoryEavRepository->deleteOneById($id);
            $this->footerLinkRepository->deleteManyBy('category_id', $id);
            return ['category_id' => $id];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }


    public function createFooterLink($dataInput): array
    {
        try {
            $orderNumber = 1;
            $lastId = FooterLink::latest()->first();
            if (!empty($lastId)) {
                $orderNumber = $lastId->id + 1;
            }
            DB::beginTransaction();
            $footerLink = [
                'order_number' => $orderNumber,
                'category_id' => $dataInput['category_id']
            ];
            $link = $this->footerLinkRepository->create($footerLink);
            foreach ($dataInput as $key => $item) {
                if ($key == 'category_id' || empty($item)) {
                    continue;
                }
                $footerLinkEav = [
                    'namespace' => $link->id,
                    'attribute' => $key,
                    'value' => $item,
                    'type' => \App\Services\CommonConstant::STATUS_ACTIVE
                ];
                $this->footerLinkEavRepository->create($footerLinkEav);
            }
            DB::commit();
            $dataInput['id'] = $link->id;
            return $dataInput;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function updateFooterLink($id, $dataUpdate): array
    {
        try {
            DB::beginTransaction();
            $isCheckFooterLink = $this->footerLinkRepository->findOneById($id);
            if (empty($isCheckFooterLink)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            if (!empty($dataUpdate['category_id'])) {
                $this->footerLinkRepository->updateOneById($id, ['category_id' => $dataUpdate['category_id']]);
            }
            foreach ($dataUpdate as $key => $item) {
                if ($key == 'category_id') {
                    continue;
                }
                $isCheck = $this->footerLinkEavRepository->findOneByCredentials(['namespace' => $id, 'attribute' => $key]);
                $footerLinkCategoryEav = [
                    'namespace' => $id,
                    'attribute' => $key,
                    'value' => $item,
                    'type' => \App\Services\CommonConstant::STATUS_ACTIVE
                ];
                if (!empty($isCheck)) {
                    if (empty($item)) {
                        $this->footerLinkEavRepository->deleteOneById($isCheck->id);
                        continue;
                    }
                    $this->footerLinkEavRepository->updateOneByCondition(['namespace' => $id, 'attribute' => $key], $footerLinkCategoryEav);
                } else {
                    if (empty($item)) {
                        continue;
                    }
                    $this->footerLinkEavRepository->create($footerLinkCategoryEav);
                }
            }
            DB::commit();
            $dataUpdate['id'] = $id;
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getListFooterLinkByCategory($categoryId): array
    {
        try {
            $dataResult = [];
            $listFooterLink = $this->footerLinkRepository->findManyBy('category_id', $categoryId);
            if ($categoryId == 0) {
                $listFooterLink = $this->footerLinkRepository->findAll();
            }
            if (empty($listFooterLink)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            foreach ($listFooterLink->toArray() as $key => $value) {
                $footerLinkEav = $this->footerLinkEavRepository->findManyBy('namespace', $value['id']);
                $dataResult['data'][] = array_merge($value, $this->convertData($footerLinkEav));
            }
            return $dataResult;
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function getDetailFooterLink($id): array
    {
        try {
            $footerLink = $this->footerLinkRepository->findOneById($id);
            if (empty($footerLink)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            $footerLinkEav = $this->footerLinkEavRepository->findManyBy('namespace', $id);
            return array_merge($footerLink->toArray(), $this->convertData($footerLinkEav));
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function deleteFooterLink($id): array
    {
        try {
            DB::beginTransaction();
            $footerLink = $this->footerLinkRepository->findOneById($id);
            if (empty($footerLink)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => null
                ];
            }
            $this->footerLinkRepository->deleteOneById($id);
            $this->footerLinkEavRepository->deleteOneByKey('namespace', $id);
            DB::commit();
            return ['id' => $id];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    private function convertData($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value->attribute] = $value->value;
        }
        return $result;
    }


}
