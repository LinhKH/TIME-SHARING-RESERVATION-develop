<?php

namespace App\Services;

use App\Repositories\Reservations\ReservationRepository;
use App\Services\CommonConstant;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class ReservationServices
{
    protected ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function getListReservation($request): array
    {
        try {
            $search = $request->all();

            $data = $this->reservationRepository->getListReservation($search, CommonConstant::PAGINATE_LIMIT_RESSERVATION);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function getListRervationByCustomer(): array
    {
        try {
            $customerId = auth()->user()->id;
            $data = $this->reservationRepository->getListRervationByCustomer($customerId, CommonConstant::PAGINATE_LIMIT_RESSERVATION_FE);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function getFirstContractorReservation($request): array
    {
        try {
            $user = $request->user();
            $data = $this->reservationRepository->getFirstContractorReservation($user);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
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
    public function getDetailReservation(int $id): array
    {
        $this->reservationRepository->findOneById($id);

        try {
            $data = $this->reservationRepository->getDetailReservation($id);

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
     * @param int $id
     * @return array
     */
    public function getDetailRervationByCustomer(int $id): array
    {
        $this->reservationRepository->findOneById($id);

        try {
            $data = $this->reservationRepository->getDetailReservation($id);

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
     * @param int $id
     * @param array $dataUpdate
     * @return array
     */
    public function handleUpdateStatusReservation(int $id, array $dataUpdate): array
    {
        $reservation = $this->reservationRepository->findOneById($id);

        try {
            $status = $this->getStatusReservation($dataUpdate['status']);
            $dataUpdate['status'] = $status;
            $dataUpdate['previous_status'] = $reservation->status;

            $data = $this->reservationRepository->updateOneById($id, $dataUpdate);

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
     * @param int $status
     * @return string
     */
    public function getStatusReservation(int $status): string
    {
        switch ($status) {
            case 1:
                return CommonConstant::RESERVARION_STATUS_PROCESSING;
                break;
            case 2:
                return CommonConstant::RESERVARION_STATUS_APPROVED;
                break;
            case 3:
                return CommonConstant::RESERVARION_STATUS_REJECT;
                break;
            case 4:
                return CommonConstant::RESERVARION_REQUEST_CANCELED;
                break;
            case 5:
                return CommonConstant::RESERVARION_WAITING_FOR_CARD_INFORMATION_INPUT;
                break;
            case 6:
                return CommonConstant::RESERVARION_COMPLETED_CASH_PAYMENT;
                break;
            default:
                return CommonConstant::RESERVARION_STATUS_PENDING;
                break;
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function isCheckUsingSpace($id): array
    {
        try {

            $isCheck = $this->reservationRepository->findOneBy('rental_space_id', $id);
            if (empty($isCheck)) {
                return [
                    'data' => null,
                    'status' => Response::HTTP_OK,
                ];
            }
            return [
                'data' => $isCheck,
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
