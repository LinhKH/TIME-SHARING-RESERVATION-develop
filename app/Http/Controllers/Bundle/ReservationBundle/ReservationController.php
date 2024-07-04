<?php

namespace App\Http\Controllers\Bundle\ReservationBundle;

use App\Bundle\CustomerBundle\Infrastructure\CustomerRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Bundle\ReservationBundle\Application\ReservationManageListGetApplicationService;
use App\Bundle\ReservationBundle\Application\ReservationManageListGetCommand;
use App\Bundle\ReservationBundle\Application\ReservationPlanLessPostApplicationService;
use App\Bundle\ReservationBundle\Application\ReservationPlanLessPostCommand;
use App\Bundle\ReservationBundle\Infrastructure\ReservationRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalPlanRepository;
use App\Bundle\UserBundle\Infrastructure\UserRepository;
use App\Exports\ReservationExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Services\ApiServices;
use App\Services\CommonConstant;
use App\Services\ReservationServices;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public ReservationServices $reservationServices;
    protected ApiServices $apiServices;

    public function __construct(ReservationServices $reservationServices, ApiServices $apiServices)
    {
        $this->reservationServices = $reservationServices;
        $this->apiServices = $apiServices;
    }

    /**
     * Admin - API Get all reservation
     */
    public function getAllReservation(): JsonResponse
    {
        $reservationRepository = new ReservationRepository();
        $generalRepository = new RentalSpaceGeneralRepository();
        $customerRepository = new CustomerRepository();
        $userRepository = new UserRepository();
        $getReservationManageApplicationService = new ReservationManageListGetApplicationService(
            $reservationRepository,
            $generalRepository,
            $customerRepository,
            $userRepository
        );
        $command = new ReservationManageListGetCommand(
            !empty($request['page']) ? (int)$request['page'] : 1
        );

        $reservationManages = $getReservationManageApplicationService->handle($command);
        $data = [];
        foreach ($reservationManages->reservationManages as $reservationManage) {

            $data[] = [
                'id' => $reservationManage->reservationId,
                'customer' => [
                    'customer_id' => $reservationManage->customer->id,
                    'first_name' => $reservationManage->customer->firstName,
                    'last_name' => $reservationManage->customer->lastName,

                ],
                'rental_space' => [
                    'rental_space_id' => $reservationManage->rentalSpace->rentalSpaceId,
                    'space_name' => $reservationManage->rentalSpace->spaceName,
                ],
                'use_purpose_category' => $reservationManage->usePurposeCategory,
                'date_of_use' => $reservationManage->dateOfUse,
                'plan_less_start_time' => $reservationManage->planLessStartTime,
                'plan_less_end_time' => $reservationManage->planLessEndTime,
                'status' => $reservationManage->status,
                'register_date_time' => $reservationManage->registerDateTime,
                'coupon' => [
                    'coupon_id' => $reservationManage->couponUsed->couponId,
                    'coupon_name' => $reservationManage->couponUsed->couponName,
                    'coupon_discount_percentage' => $reservationManage->couponUsed->couponDiscountPercentage
                ],
                'user' => [
                    'user_id' => $reservationManage->user->id,
                    'first_name' => $reservationManage->user->firstName,
                    'last_name' => $reservationManage->user->lastName,
                ]
            ];
        }


        $response = [
            'data' => $data,
            'pagination' => [
                'total' => $reservationManages->pagination->totalPage,
                'per_page' => $reservationManages->pagination->perPage,
                'current_page' => $reservationManages->pagination->currentPage,
            ],
        ];

        return response()->json($response, 200);
    }


    /**
     * @param Request $request Illuminate\Http\Request
     * @return JsonResponse
     */
    public function getListReservation(Request $request): JsonResponse
    {
        $data = $this->reservationServices->getListReservation($request);

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListStatusReservation(): JsonResponse
    {
        $data = CommonConstant::STATUS_RESERVATION;

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListPurposeOfUse(): JsonResponse
    {
        $data = CommonConstant::PURPOSE_OF_USE;

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListFrontendReservationType(): JsonResponse
    {
        $data = CommonConstant::FRONTEND_RESERVATION_TYPE;

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListReservationType(): JsonResponse
    {
        $data = CommonConstant::RESERVATION_TYPE;

        return response()->json($data, 200);
    }

    /**
     * @param Request $request Illuminate\Http\Request
     * @return JsonResponse
     */
    public function getFirstContractorReservation(Request $request): JsonResponse
    {
        $data = $this->reservationServices->getFirstContractorReservation($request);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDetailReservation(int $id): JsonResponse
    {
        $data = $this->reservationServices->getDetailReservation($id);

        return response()->json($data, 200);
    }

    public function handleExportReservation()
    {
        try {
            return Excel::download(new ReservationExport('default'), 'reservation-list.csv');
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    public function handleExportFirstContractorReservation()
    {
        try {
            return Excel::download(new ReservationExport('first-contractor'), 'first-contractor-reservation.csv');
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param ReservationUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function handleUpdateStatusReservation(ReservationUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $res = $this->reservationServices->handleUpdateStatusReservation($id, $data);

        return response()->json($res, 200);
    }

    /**
     * Admin - API Get list interval of Plan
     */

    public function getListIntervalOfPlan(int $spaceId, string $dayIdent): JsonResponse
    {
        $rentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $dataResult = $rentalPlanRepository->getListIntervalOfPlan($spaceId, $dayIdent);

        return response()->json($dataResult, 200);
    }

    /**
     * Admin - Create reservation
     */
    public function postReservationPlanLess(ReservationRequest $request, $rentalSpaceId): JsonResponse
    {
        $reservationRepository = new ReservationRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $customerRepository = new CustomerRepository();
        $postPlanApplicationService = new ReservationPlanLessPostApplicationService(
            $rentalSpaceGeneralRepository,
            $customerRepository,
            $reservationRepository
        );

        $command = new ReservationPlanLessPostCommand(
            $rentalSpaceId,
            $request->proxy_reservation_type,
            $request->day,
            $request->plan_less_start_time,
            $request->plan_less_end_time,
            $request->people_count,
            $request->business_structure,
            $request->use_purpose_category,
            $request->use_purpose_for_other,
            $request->total_price_override_sans_tax,
            $request->limited_discount_price_sans_tax ?? null,
            $request->discount ?? null,
            $request->coupon_name ?? null,
            $request->coupon_id ?? null,
            $request->customer_email,
            $request->memo_owner ?? null,
            $request->memo_customer ?? null
        );
        $reservationPlanLess = $postPlanApplicationService->handle($command);

        return response()->json([
            'rental_space_id' => $rentalSpaceId,
            'reservation_id' => $reservationPlanLess->reservationId
        ], 200);
    }

    public function handelBookingSpace(Request $request)
    {

        $reservationRepository = new ReservationRepository();

        $dataResult = $reservationRepository->handelBookingSpace($request->all());

        return response($dataResult);
    }
}
