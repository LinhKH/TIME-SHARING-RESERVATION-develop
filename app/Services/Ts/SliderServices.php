<?php

namespace App\Services\Ts;

use App\Repositories\TsSlider\SliderRepository;
use App\Repositories\TsSliderItem\SliderItemRepository;
use App\Services\CommonConstant;
use App\Services\ApiServices;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SliderServices
{
    protected SliderItemRepository $sliderItemRepository;
    protected SliderRepository $sliderRepository;
    protected ApiServices $apiServices;

    public function __construct(SliderRepository $sliderRepository, ApiServices $apiServices, SliderItemRepository $sliderItemRepository)
    {
        $this->sliderItemRepository = $sliderItemRepository;
        $this->sliderRepository = $sliderRepository;
        $this->apiServices = $apiServices;

    }

    /**
     * @param $data
     * @return array
     */
    public function createSlider($data): array
    {
        try {
            $title = $data['title'];
            $sliderItem = $data['item'] ?? [];
            DB::beginTransaction();
            $slider = $this->sliderRepository->create(['title' => $title]);
            foreach ($sliderItem as $item) {
                $item['slider_id'] = $slider->id;
                $this->sliderItemRepository->create($item);
            }
            $data['id'] = $slider->id;
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
     * @param $data
     * @return array
     */

    public function updateSlider($id, $data): array
    {
        try {
            DB::beginTransaction();
            if (!empty($data['title'])) {
                $this->sliderRepository->updateOneById($id, ['title' => $data['title']]);
            }
            $sliderItem = $data['item'] ?? [];
            foreach ($sliderItem as $item) {
                $itemId = $item['id'];
                unset($item['id']);
                $this->sliderItemRepository->updateOneById($itemId, $item);
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
     * @return array
     */

    public function getListSlider(): array
    {
        try {
            $data = $this->sliderRepository->paginate(CommonConstant::PER_PAGE);
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

    public function getDetailSlider($id): array
    {
        try {
            $dataResult = $this->sliderRepository->findOneBy('id', $id);
            if (empty($dataResult)) {
                return [
                    'status' => CommonConstant::ERROR_CODE,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $listItem = $this->sliderItemRepository->findManyBy('slider_id', $dataResult->id);
            if (!empty($listItem)) {
                foreach ($listItem as $value) {
                    $value->img = Storage::url($value->img);
                }
            }
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
     * @param $ids
     * @return array
     */
    public function deleteByIds($ids): array
    {
        try {
            DB::beginTransaction();
            foreach ($ids as $id) {
                $isCheck = $this->sliderRepository->findOneBy('id', $id);
                if (empty($isCheck)) {
                    continue;
                }
                $this->sliderRepository->deleteOneById($id);
                $this->sliderItemRepository->deleteManyBy('slider_id', $id);
            }
            DB::commit();
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $ids
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
}
