<?php

namespace App\Http\Controllers\Bundle\CustomerBundle;

use App\Bundle\CustomerBundle\Application\CustomerManageGetApplicationService;
use App\Bundle\CustomerBundle\Application\CustomerManageGetCommand;
use App\Bundle\CustomerBundle\Application\CustomerManageListGetApplicationService;
use App\Bundle\CustomerBundle\Application\CustomerManageListGetCommand;
use App\Bundle\CustomerBundle\Application\CustomerManagePostApplicationService;
use App\Bundle\CustomerBundle\Application\CustomerManagePostCommand;
use App\Bundle\CustomerBundle\Application\CustomerManageReceivingEmailPutApplicationService;
use App\Bundle\CustomerBundle\Application\CustomerManageReceivingEmailPutCommand;
use App\Bundle\CustomerBundle\Application\CustomerManageStatusPutApplicationService;
use App\Bundle\CustomerBundle\Application\CustomerManageStatusPutCommand;
use App\Bundle\CustomerBundle\Infrastructure\CustomerRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerManagePostRequest;
use App\Http\Requests\CustomerStatusPutRequest;
use App\Http\Requests\CustomerUpdateInfoCard;
use App\Http\Requests\CustomerUpdateRegisteredRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Services\CustomerServices;
use App\Services\ReservationServices;
use App\Services\TourServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

class CustomerManagementController extends Controller
{

    public CustomerServices $customerServices;
    public TourServices $tourServices;
    public ReservationServices $reservationServices;

    public function __construct(CustomerServices $customerServices, TourServices $tourServices, ReservationServices $reservationServices)
    {
        $this->customerServices = $customerServices;
        $this->tourServices = $tourServices;
        $this->reservationServices = $reservationServices;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListCustomer(Request $request): JsonResponse
    {
        $data = $this->customerServices->getListCustomer($request);

        return response()->json($data, 200);
    }

    /**
     * @param CustomerUpdateRequest $request
     * @return JsonResponse
     */
    public function handleUpdateCustomer(CustomerUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->customerServices->handleUpdateCustomer($data);

        return response()->json($res, 200);
    }

    /**
     * @param CustomerUpdateRegisteredRequest $request
     * @return JsonResponse
     */
    public function handleUpdateInfoRegistered(CustomerUpdateRegisteredRequest $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->customerServices->handleUpdateInfoRegistered($data);

        return response()->json($res, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListAddress(): JsonResponse
    {
        $data = $this->customerServices->getListAddress();

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getInfoCustomer(): JsonResponse
    {
        $data = $this->customerServices->getInfoCustomer();

        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListTourOfCustomer(): JsonResponse
    {
        $data = $this->tourServices->getListTourOfCustomer();

        return response()->json($data, 200);
    }

    /**
     * @param int $tourId
     * @return JsonResponse
     */
    public function getDetailTourOfCustomer(int $tourId): JsonResponse
    {
        $data = $this->tourServices->getDetailTourOfCustomer($tourId);

        return response()->json($data, 200);
    }


    /**
     * @param CustomerUpdateInfoCard $request
     * @return JsonResponse
     */
    public function handleUpdateInfoCard(CustomerUpdateInfoCard $request): JsonResponse
    {
        $data = $request->validated();
        $res = $this->customerServices->handleUpdateInfoCard($data);

        return response()->json($res, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getListRervationByCustomer(): JsonResponse
    {
        $data = $this->reservationServices->getListRervationByCustomer();

        return response()->json($data, 200);
    }

    /**
     * @param int $reservationId
     * @return JsonResponse
     */
    public function getDetailRervationByCustomer(int $reservationId): JsonResponse
    {
        $data = $this->reservationServices->getDetailRervationByCustomer($reservationId);

        return response()->json($data, 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomers(Request $request): JsonResponse
    {
        $customerRepository = new CustomerRepository();
        $applicationService = new CustomerManageListGetApplicationService(
            $customerRepository
        );
        $command = new CustomerManageListGetCommand(
            // filter orderby
            $request->created_at ?? null,
            $request->total_fee ?? null,
            $request->number_of_reviews ?? null,

            $request->first_name ?? null,
            $request->email ?? null,
            $request->address ?? null,
            $request->membership_type ?? null,
            $request->phone_number ?? null,
            $request->email_status ?? null,
            $request->phone_number_status ?? null,
            $request->e_mail_magazine ?? null,
            $request->status ?? null,
            $request->registration_date_start ?? null,
            $request->registration_date_end ?? null
        );

        $result = $applicationService->handle($command);

        $customerManageResults = $result->customerManageResults;
        $paginationResult = $result->paginationResult;

        if (!empty($request->total_fee)) {
            $totalPriceSansTax = array_column($customerManageResults, 'totalPriceSansTax');
            array_multisort($totalPriceSansTax, SORT_DESC, $customerManageResults);
        }

        if (!empty($request->number_of_reviews)) {
            $numberOfReviews = array_column($customerManageResults, 'numberOfReviews');
            array_multisort($numberOfReviews, SORT_DESC, $customerManageResults);
        }

        $data = [];
        foreach ($customerManageResults as $customerManageResult) {
            $data[] = [
                'customer_id' => $customerManageResult->customerId,
                'status' => $customerManageResult->isActive,
                'membership_type' => $customerManageResult->customerType,
                'gender' => $customerManageResult->genderType,
                'registration_date' => $customerManageResult->creationTime,
                'email' => $customerManageResult->email,
                'first_name' => $customerManageResult->firstName,
                'last_name' => $customerManageResult->lastName,
                'first_name_kana' => $customerManageResult->firstNameKana,
                'last_name_kana' => $customerManageResult->lastNameKana,
                'phone_number' => $customerManageResult->phoneNumber,
                'address' => $customerManageResult->address,
                'birthday' => $customerManageResult->birthday,
                'number_of_reviews' => $customerManageResult->numberOfReviews,
                'total_price_sans_tax' => $customerManageResult->totalPriceSansTax,
            ];
        }
        $response = [
            'data' => $data,
            'pagination' => [
                'total' => $paginationResult->totalPage,
                'per_page' => $paginationResult->perPage,
                'current_page' => $paginationResult->currentPage,
            ],
        ];

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCustomer(Request $request): JsonResponse
    {
        $applicationService = new CustomerManageGetApplicationService(
            new CustomerRepository()
        );
        $customerId = $request->id;
        $command = new CustomerManageGetCommand($customerId);
        $result = $applicationService->handle($command);

        $data = [
            'customer_id' => $result->customerId,
            'status' => $result->isActive,
            'membership_type' => $result->customerType,
            'gender' => $result->genderType,
            'registration_date' => $result->creationTime,
            'email' => $result->email,
            'first_name' => $result->firstName,
            'last_name' => $result->lastName,
            'first_name_kana' => $result->firstNameKana,
            'last_name_kana' => $result->lastNameKana,
            'phone_number' => $result->phoneNumber,
            'address' => $result->address,
            'birthday' => $result->birthday,
            'number_of_reviews' => $result->numberOfReviews,
            'total_price_sans_tax' => $result->totalPriceSansTax,
            'company_name' => $result->companyName,
            'company_name_kana' => $result->companyNameKana,
            'credit_card_information' => $result->creditCardInformation,
            'latest_activity' => $result->latestActivity,
            'news_letter_subscribed' => $result->receivingReservationEmails,
        ];

        $customerRepository = new CustomerRepository();
        $nameSpace = $customerRepository->getAllNameSpaceByCustomer($customerId);
        $data['nameSpace'] = $nameSpace;

        return response()->json($data, 200);
    }

    /**
     * @param CustomerManagePostRequest $request
     * @return JsonResponse
     */
    public function createCustomer(CustomerManagePostRequest $request): JsonResponse
    {
        $applicationService = new CustomerManagePostApplicationService(
            new CustomerRepository()
        );
        $command = new CustomerManagePostCommand(
            $request->email,
            bcrypt($request->password)
        );

        $result = $applicationService->handle($command);
        $data = [
            'customer_id' => $result->customerId,
        ];

        return response()->json($data, 200);
    }

    /**
     * @param CustomerStatusPutRequest $request
     * @return JsonResponse
     */
    public function updateCustomerStatus(CustomerStatusPutRequest $request): JsonResponse
    {
        $applicationService = new CustomerManageStatusPutApplicationService(
            new CustomerRepository()
        );
        $command = new CustomerManageStatusPutCommand(
            (int)$request->id,
            (bool)$request->is_active
        );

        $result = $applicationService->handle($command);
        $data = [
            'customer_id' => $result->customerId,
        ];

        return response()->json($data, 200);
    }

    /**
     * @param CustomerStatusPutRequest $request
     * @return JsonResponse
     */
    public function updateReceivingReservationEmail(Request $request): JsonResponse
    {
        $applicationService = new CustomerManageReceivingEmailPutApplicationService(
            new CustomerRepository()
        );
        $command = new CustomerManageReceivingEmailPutCommand(
            (int)$request->id,
            (bool)$request->is_receiving_reservation_email
        );

        $result = $applicationService->handle($command);
        $data = [
            'customer_id' => $result->customerId,
        ];

        return response()->json($data, 200);
    }


    public function updatePassCustomer($id, Request $request): bool
    {
        $pass = bcrypt($request->input('password'));
        DB::table('customer')
            ->where('id', $id)  // find your user by their email
            ->update(array('password' => $pass));  // update the record in the DB
        return true;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public
    function handleFilterCustomer(Request $request): JsonResponse
    {
        $data = $this->customerServices->handleFilterCustomer($request);
        return response()->json($data, 200);
    }
}
