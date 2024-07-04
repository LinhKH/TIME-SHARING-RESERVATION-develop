<?php

namespace App\Services;

use App\Exports\InquiryExport;
use App\Repositories\Inquiry\InquiryRepository;
use App\Repositories\InquiryReply\InquiryReplyRepository;
use App\Services\CommonConstant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class InquiryServices
{
    protected InquiryRepository $inquiryRepository;
    protected InquiryReplyRepository $inquiryReplyRepository;

    public function __construct(InquiryRepository $inquiryRepository, InquiryReplyRepository $inquiryReplyRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
        $this->inquiryReplyRepository = $inquiryReplyRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function getListInquiryByProduct($request): array
    {
        try {
            $auth = auth()->user();
            $search = $request->all();

            $data = $this->inquiryRepository->getListInquiryByProduct($search, $auth);

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
     * @return array
     */
    public function getDetailInquiry(int $id): array
    {
        $this->inquiryRepository->findOneById($id);

        try {
            $auth = auth()->user();
            $data = $this->inquiryRepository->getDetailInquiry($id, $auth);

            if ($auth->getTable() !== 'users' && empty($data)) {
                return [
                    "data" => null,
                    'status' => Response::HTTP_FORBIDDEN
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
     * @param $dataCreate
     * @return array
     */
    public function createInquiry($dataCreate): array
    {
        try {
            DB::beginTransaction();

            $dataCreate['customer_id'] = auth()->user()->id;
            $dataCreate['creation_time'] = Carbon::now()->format('Ymd');
            $result = $this->inquiryRepository->create($dataCreate);

            $dataReply = [
                'customer_id' => auth()->user()->id,
                'description' => $dataCreate['description'] ?? null,
                'creation_time' => Carbon::now()->format('Ymd'),
                'is_read' => CommonConstant::STATUS_UN_ACTIVE,
                'inquiry_id' => $result->id
            ];
            $this->inquiryReplyRepository->create($dataReply);

            DB::commit();

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
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
     * @param $dataCreate
     * @param int $spaceId
     *
     * @return array
     */
    public function createInquirySpace($dataCreate, $spaceId): array
    {
        try {
            $checkInquirySpace = $this->inquiryReplyRepository->handleCheckInquirySpace($spaceId);
            if (!empty($checkInquirySpace)) {
                $this->handleInquiryReplySpace($dataCreate['description'], $dataCreate['guest_information'], $checkInquirySpace->id);
            } else {

                DB::beginTransaction();

                $dataCreate['creation_time'] = Carbon::now()->format('Ymd');
                $dataCreate['rental_space_id'] = $spaceId;
                $result = $this->inquiryRepository->create($dataCreate);

                $dataReply = [
                    'description' => $dataCreate['description'] ?? null,
                    'guest_information' => $dataCreate['guest_information'],
                    'creation_time' => Carbon::now()->format('Ymd'),
                    'is_read' => CommonConstant::STATUS_UN_ACTIVE,
                    'inquiry_id' => $result->id
                ];

                $this->inquiryReplyRepository->create($dataReply);

                DB::commit();
            }

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
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
     * @param $dataCreate
     * @param int $inquiryId
     * @return array
     */
    public function handleInquiryReply($dataCreate, int $inquiryId): array
    {
        $this->inquiryRepository->findOneById($inquiryId);

        try {
            $auth = auth()->user();
            if ($auth->getTable() === 'users') {
                $dataCreate['user_id'] = $auth->id;
            } else {
                $dataCreate['customer_id'] = $auth->id;
            }

            $dataCreate['creation_time'] = Carbon::now()->format('Ymd');
            $dataCreate['inquiry_id'] = $inquiryId;

            $result = $this->inquiryReplyRepository->create($dataCreate);

            return $this->getInquiryReplyEntity($result->id);
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
     * @param int $inquiryId
     *
     * @return array
     */
    public function handleInquiryReplySpace($description, $guestInformation, int $inquiryId): array
    {
        $this->inquiryRepository->findOneById($inquiryId);

        try {
            $dataCreate['creation_time'] = Carbon::now()->format('Ymd');
            $dataCreate['inquiry_id'] = $inquiryId;
            $dataCreate['description'] = $description;
            $dataCreate['guest_information'] = $guestInformation;

            $this->inquiryReplyRepository->create($dataCreate);

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
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
     * handleExportInquiry
     */
    public function handleExportInquiry()
    {
        try {
            return Excel::download(new InquiryExport(), 'inquiry-admin.csv');
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getInquiryEntity(int $id): array
    {
        $data = $this->inquiryRepository->findOneById($id);

        return [
            'data' => $data->toArray(),
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getInquiryReplyEntity(int $id): array
    {
        $data = $this->inquiryReplyRepository->findOneById($id);

        return [
            'data' => $data->toArray(),
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * @param $id
     * @return array
     */

    public function getListInquiryReply($id): array
    {
        $dataResult = $this->inquiryReplyRepository->getListReply($id);
        if (empty($dataResult)) {
            return [
                "status" => CommonConstant::ERROR_CODE,
                "msg" => CommonConstant::MSG_EXISTS_DATA,
                "result" => null
            ];
        }
        return $dataResult;
    }

    /**
     * @param $spaceId
     *
     * @return array
     */
    public function getListReplySpace(int $spaceId): array
    {
        try {
            $infoInquirySpace = $this->inquiryReplyRepository->handleCheckInquirySpace($spaceId);
            if (empty($infoInquirySpace)) {
                return [
                    "status" => CommonConstant::EXIT_DATA,
                    "msg" => CommonConstant::MSG_EXISTS_DATA,
                ];
            }

            $dataResult = $this->inquiryReplyRepository->getListReplySpace($infoInquirySpace->id);

            if (!empty($dataResult)) {
                return [
                    'status' => Response::HTTP_OK,
                    'data' => $dataResult
                ];
            }
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
     * @param $status
     * @return array
     */

    public function updateStatusInquiry($status, $id): array
    {
        try {
            $this->inquiryRepository->updateOneById($id, ['support_done' => $status]);
            return ['id' => $id, 'support_done' => $status];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $id
     * @param $is_read
     * 
     * @return array
     */

    public function updateIsReadInquiry($is_read, $id): array
    {
        $this->inquiryRepository->findOneById($id);

        try {
            $this->inquiryRepository->updateOneById($id, ['is_read' => $is_read]);
            
            return ['id' => $id, 'is_read' => $is_read];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
