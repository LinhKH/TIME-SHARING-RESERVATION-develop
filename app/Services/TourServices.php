<?php

namespace App\Services;

use App\Repositories\Tour\TourRepository;
use App\Repositories\TourReply\TourReplyRepository;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TourServices
{
    protected TourRepository $tourRepository;
    protected TourReplyRepository $replyRepository;

    public function __construct(TourRepository $tourRepository, TourReplyRepository $replyRepository)
    {
        $this->tourRepository = $tourRepository;
        $this->replyRepository = $replyRepository;
    }

    public function updateStatusTour($dataInput, $id): array
    {
        try {
            $status = $dataInput['status'];
            $isCheckTour = $this->tourRepository->findOneBy('id', $id);
            if (empty($isCheckTour)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            if (empty(CommonConstant::STATUS_TOUR[$status])) {
                return [
                    "status" => CommonConstant::MISS_PARAM_CODE,
                    "msg" => 'status does not exist',
                    "result" => null
                ];
            }
            $dataUpdate = [];
            switch ($status) {
                case CommonConstant::STATUS_TOUR['fix_date_time']:
                case CommonConstant::STATUS_TOUR['waiting_response_user']:
                    if (empty($dataInput['fix_choice_date_column_name']) || empty($dataInput['fix_choice_time_column_name'])) {
                        return [
                            "status" => CommonConstant::MISS_PARAM_CODE,
                            "msg" => 'miss param column name',
                            "result" => null
                        ];
                    }
                    $dataUpdate = [
                        'status' => $status,
                        'fix_choice_date_column_name' => $dataInput['fix_choice_date_column_name'],
                        'fix_choice_time_column_name' => $dataInput['fix_choice_time_column_name']
                    ];
                    break;
                case CommonConstant::STATUS_TOUR['user_cancel']:
                case CommonConstant::STATUS_TOUR['observation_NG']:
                    $dataUpdate['status'] = $status;
                    break;
                case CommonConstant::STATUS_TOUR['change_date_time']:
                    if (empty($dataInput['substitute_first_choice_date']) || empty($dataInput['substitute_first_choice_time'])) {
                        return [
                            "status" => CommonConstant::MISS_PARAM_CODE,
                            "msg" => 'miss param choice date or time',
                            "result" => null
                        ];
                    }
                    $dataUpdate = [
                        'status' => $status,
                        'substitute_first_choice_date' => $dataInput['substitute_first_choice_date'],
                        'substitute_first_choice_time' => $dataInput['substitute_first_choice_time'],
                        'substitute_second_choice_date' => $dataInput['substitute_second_choice_date'] ?? null,
                        'substitute_second_choice_time' => $dataInput['substitute_second_choice_time'] ?? null,
                        'substitute_third_choice_date' => $dataInput['substitute_third_choice_date'] ?? null,
                        'substitute_third_choice_time' => $dataInput['substitute_third_choice_time'] ?? null
                    ];
                    break;
            }
            $this->tourRepository->updateOneById($id, $dataUpdate);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $this->tourRepository->findOneBy('id', $id)
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
     * @param $status
     * @param $id
     * @return array
     */
    public function updateStatusByCustomer($status, $id): array
    {
        try {

            $isCheckTour = $this->tourRepository->findOneBy('id', $id);
            if (empty($isCheckTour)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }

            if (empty(CommonConstant::STATUS_TOUR[$status])) {
                return [
                    "status" => CommonConstant::MISS_PARAM_CODE,
                    "msg" => 'status does not exist',
                    "result" => null
                ];
            }
            $this->tourRepository->updateOneById($id, ['status' => $status]);
            return [
                'status' => CommonConstant::SUCCESS_CODE,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
                "result" => $this->tourRepository->findOneBy('id', $id)
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
     * @return array
     */
    public function getListTourOfCustomer(): array
    {
        try {
            $customerId = auth()->user()->id;
            $data = $this->tourRepository->getListTourOfCustomer($customerId);

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
     * @param int $tourId
     * @return array
     */
    public function getDetailTourOfCustomer(int $tourId): array
    {
        $this->tourRepository->findOneById($tourId);

        try {
            $data = $this->tourRepository->getDetailTourOfCustomer($tourId);

            if (!empty($data['user_id'] != auth()->user()->id)) {
                return [
                    'status' => Response::HTTP_NOT_FOUND,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }

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
     * @param $data
     * @return array
     */
    public function addNewReply($data): array
    {
        try {
            $dataInsert = [
                'tour_id' => $data['tour_id'],
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => $data['user_id'] ?? null,
                'description' => $data['description'],
                'creation_time' => Carbon::now()->format('Ymd'),
                'is_read' => 0
            ];

            $result = $this->replyRepository->create($dataInsert);
            return [
                'data' => $result,
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
     * @param $id
     * @return array
     */
    public function getListReply($id): array
    {
        try {
            $data = $this->replyRepository->findManyBy('tour_id', $id);
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
     * @param $id
     * @return array
     */
    public function deleteTour($id): array
    {
        try {
            $customerId = auth()->user()->id;

            $isCheck = $this->tourRepository->findOneByCredentials(['user_id' => $customerId, 'id' => $id]);
            if (empty($isCheck)) {
                return [
                    'status' => CommonConstant::EXIT_DATA,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                    "result" => null
                ];
            }
            $this->tourRepository->deleteOneById($id);
            return [
                'data' => ['id' => $id],
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

}
