<?php

namespace App\Http\Controllers\Bundle\TourBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\CustomerBundle\Infrastructure\CustomerRepository;
use App\Bundle\OrganizationBundle\Infrastructure\OrganizationRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRepository;
use App\Bundle\TourBundle\Application\TourApprovalApplicationService;
use App\Bundle\TourBundle\Application\TourApprovalCommand;
use App\Bundle\TourBundle\Application\TourGetDetailApplicationService;
use App\Bundle\TourBundle\Application\TourGetDetailCommand;
use App\Bundle\TourBundle\Application\TourGetManageSettingApplicationService;
use App\Bundle\TourBundle\Application\TourGetManageSettingCommand;
use App\Bundle\TourBundle\Application\TourListGetApplicationService;
use App\Bundle\TourBundle\Application\TourListGetCommand;
use App\Bundle\TourBundle\Application\TourNonApprovalApplicationService;
use App\Bundle\TourBundle\Application\TourNonApprovalCommand;
use App\Bundle\TourBundle\Application\TourPostApplicationService;
use App\Bundle\TourBundle\Application\TourPostCommand;
use App\Bundle\TourBundle\Application\TourPutUpdateSettingApplicationService;
use App\Bundle\TourBundle\Application\TourPutUpdateSettingCommand;
use App\Bundle\TourBundle\Infrastructure\TourRepository;
use App\Bundle\UserBundle\Infrastructure\UserRepository;
use App\Bundle\CustomerBundle\Application\CustomerManageGetApplicationService;
use App\Http\Controllers\Controller;
use App\Services\TourServices;
use App\Services\ApiServices;
use App\Http\Requests\TourApprovalRequest;
use App\Http\Requests\TourNonApprovalRequest;
use App\Http\Requests\TourPutUpdateSettingRequest;
use App\Http\Requests\TourRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bundle\CustomerBundle\Application\CustomerManageGetCommand;

class TourController extends Controller
{

    protected ApiServices $apiServices;
    protected TourServices $tourServices;

    public function __construct(
        ApiServices  $apiServices,
        TourServices $tourServices
    )
    {
        $this->apiServices = $apiServices;
        $this->tourServices = $tourServices;
    }

    /**
     * @param TourRequest $request
     * @param int $rentalSpaceId
     * @return JsonResponse
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function addAction(TourRequest $request, int $rentalSpaceId): JsonResponse
    {
        $tourRepository = new TourRepository();
        $applicationService = new TourPostApplicationService(
            $tourRepository
        );

        $command = new TourPostCommand(
            Auth::id(),
            $rentalSpaceId,
            $request->first_choice_date,
            $request->first_choice_time,
            $request->second_choice_date ?? null,
            $request->second_choice_time ?? null,
            $request->third_choice_date ?? null,
            $request->third_choice_time ?? null,
            $request->fourth_choice_date ?? null,
            $request->fourth_choice_time ?? null,
            $request->use_plans_date,
            $request->use_plans_people,
            $request->use_purpose,
            $request->use_purpose_detail,
            $request->checklist
        );

        $result = $applicationService->handle($command);

        $data = [
            'tour_id' => $result->tourId
        ];

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws RecordNotFoundException
     */
    public function manageAction(Request $request): JsonResponse
    {

        $tourRepository = new TourRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $organizationRepository = new OrganizationRepository();
        $customerRepository = new CustomerRepository();
        $applicationService = new TourListGetApplicationService(
            $tourRepository,
            $rentalSpaceGeneralRepository,
            $organizationRepository,
            $customerRepository
        );
        
        $command = new TourListGetCommand(
            !empty($request['page']) ? (int)$request['page'] : 1
        );
        
        $result = $applicationService->handle($command);

        $data = [];

        foreach ($result->resultTours as $tour) {

            $data[] = [
                'id' => $tour->tourId,
                'visitor_name' => $tour->customerName,
                'space_name' => $tour->rentalSpaceName,
                'first_choice_date' => $tour->firstChoiceDate,
                'second_choice_date' => $tour->secondChoiceDate,
                'third_choice_date' => $tour->thirdChoiceDate,
                'fix_choice_date_column_name' => $tour->fixChoiceDateName,
                'fix_choice_time_column_name' => $tour->fixChoiceTimeName,
                'substitute_first_choice_date' => $tour->subFirstChoiceDate,
                'substitute_second_choice_date' => $tour->subSecondChoiceDate,
                'substitute_third_choice_date' => $tour->subThirdChoiceDate,
                'use_plans_date' => $tour->usePlansDate,
                'use_plans_people' => $tour->usePlansPeople,
                'use_purpose' => $tour->usePurpose,
                'use_purpose_detail' => $tour->usePurposeDetail,
                'checklist' => $tour->checklist,
                'status' => $tour->tourStatus,
                'entry_time' => $tour->entryTime
            ];
        }

        $response = [
            'pagination' => [
                'total_page' => $result->paginationResult->totalPage,
                'per_page' => $result->paginationResult->perPage,
                'current_page' => $result->paginationResult->currentPage
            ],
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * @param int $tourId
     * @param TourApprovalRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException|TransactionException
     */
    public function putTourApproval(int $tourId, TourApprovalRequest $request): JsonResponse
    {
        $tourRepository = new TourRepository();
        $command = new TourApprovalCommand(
            $tourId,
            $request->tour_date,
        );

        $applicationService = new TourApprovalApplicationService($tourRepository);

        $result = $applicationService->handle($command);

        return response()->json(['id' => $result->tourId], 200);
    }

    /**
     * @param int $tourId
     * @param TourNonApprovalRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException|RecordNotFoundException|TransactionException
     */
    public function putTourNonApproval(int $tourId, TourNonApprovalRequest $request): JsonResponse
    {
        $tourRepository = new TourRepository();

        $command = new TourNonApprovalCommand(
            $tourId,
            $request->no_reason,
            $request->substitude_first_choice_date ?? null,
            $request->substitude_first_choice_time ?? null,
            $request->substitude_second_choice_date ?? null,
            $request->substitude_second_choice_time ?? null,
            $request->substitude_third_choice_date ?? null,
            $request->substitude_third_choice_time ?? null
        );

        $applicationService = new TourNonApprovalApplicationService($tourRepository);

        $result = $applicationService->handle($command);

        return response()->json(['id' => $result->tourId], 200);
    }

    /**
     * @param int $tourId
     * @return JsonResponse
     * @throws RecordNotFoundException
     * @throws InvalidArgumentException
     */
    public function getTourDetail(int $tourId): JsonResponse
    {
        $tourRepository = new TourRepository();
        $customerRepository = new CustomerRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();

        $command = new TourGetDetailCommand(
            $tourId
        );
        $applicationService = new TourGetDetailApplicationService($tourRepository, $customerRepository, $rentalSpaceGeneralRepository);
        $result = $applicationService->handle($command);

        $customer = $this->getCustomerById($result->customerId);

        $data = [
            'id' => $result->tourId,
            'space_name' => $result->rentalSpaceName,
            'user_id' => $result->userId,
            'rental_space_id' => $result->rentalSpaceId,
            'organization_id' => $result->organizationId,
            'check_list' => $result->checkList,
            'entry_time' => $result->entryTime,
            'first_choice_date' => $result->firstChoiceDate,
            'first_choice_time' => $result->firstChoiceTime,
            'second_choice_date' => $result->secondChoiceDate,
            'second_choice_time' => $result->secondChoiceTime,
            'third_choice_date' => $result->thirdChoiceDate,
            'third_choice_time' => $result->thirdChoiceTime,
            'fourth_choice_date' => $result->fourthChoiceDate,
            'fourth_choice_time' => $result->fourthChoiceTime,
            'substitute_first_choice_date' => $result->substitudeFirstChoiceDate,
            'substitute_first_choice_time' => $result->substitudeFirstChoiceTime,
            'substitute_second_choice_date' => $result->substitudeSecondChoiceDate,
            'substitute_second_choice_time' => $result->substitudeSecondChoiceTime,
            'substitute_third_choice_date' => $result->substitudeThirdChoiceDate,
            'substitute_third_choice_time' => $result->substitudeThirdChoiceTime,
            'status' => $result->status,
            'fix_choice_date_column_date' => $result->fixChoiceDateColumnDate,
            'fix_choice_date_column_time' => $result->fixChoiceDateColumnTime,
            'no_reason' => $result->noReason,
            'use_plans_date' => $result->usePlansDate,
            'use_plans_people' => $result->usePlansPeople,
            'use_purpose' => $result->usePurpose,
            'use_purpose_detail' => $result->usePurposeDetail,
            'user_view_flg' => $result->userViewFlg,
            'membership_type' => $result->customerType,
            'gender' => $result->gender,
            'company_name' => $result->companyName,
            'company_name_kana' => $result->companyNameKana,
            'customer_name' => $result->customerName,
            'customer_birthday' => $result->birthday,
            'phone' => $result->phone,
            'email' => $result->customerEmail,
            'address' => $result->customerAddress,
            'customer' => $customer
        ];
        return response()->json($data, 200);
    }

    public function getCustomerById($customerId)
    {
        $applicationService = new CustomerManageGetApplicationService(
            new CustomerRepository()
        );
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

        return $data;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateStatusTourByAdmin(Request $request, $id): JsonResponse
    {
        $credentials = $request->only('status');
        //valid credential
        $validator = Validator::make($credentials, [
            'status' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->tourServices->updateStatusTour($request->input(), $id);
        return response()->json($result, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateStatusTourByCustomer(Request $request, $id): JsonResponse
    {
        $credentials = $request->only('status');
        //valid credential
        $validator = Validator::make($credentials, [
            'status' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $result = $this->tourServices->updateStatusByCustomer($request->input('status'), $id);
        return response()->json($result, 200);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    function manageSettingAction(Request $request): JsonResponse
    {
        $rentalSpaceRepository = new RentalSpaceRepository();
        $userRepository = new UserRepository();
        $command = new TourGetManageSettingCommand(
            $request->organization_id
        );
        $application = new TourGetManageSettingApplicationService($rentalSpaceRepository, $userRepository);
        $result = $application->handle($command);
        $data = [];
        if ($result) {
            foreach ($result->rentalSpaces as $value) {
                $data[] = [
                    'rental_space_id' => $value->rentalSpaceId,
                    'name' => $value->name,
                    'tour_flg' => $value->tourFlag
                ];
            }
        }
        return response()->json(['data' => $data, 'code' => 200], 200);
    }

    function updateSettingAction(TourPutUpdateSettingRequest $request): JsonResponse
    {
        $command = new TourPutUpdateSettingCommand(
            json_encode(array_values($request->rental_space_ids)),
            $request->organization_id
        );

        $userRepository = new UserRepository();
        $tourRepository = new TourRepository();
        $rentalSpaceRepository = new RentalSpaceRepository();
        $application = new TourPutUpdateSettingApplicationService($tourRepository, $rentalSpaceRepository, $userRepository);
        $result = $application->handle($command);
        $message = "Update tour setting failed!";
        if ($result) {
            $message = "Update tour setting successfully!";
        }
        return response()->json(['message' => $message, 'code' => 200], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addNewReplyByCustomer(Request $request): JsonResponse
    {
        $credentials = $request->only('tour_id', 'description');
        //valid credential
        $validator = Validator::make($credentials, [
            'tour_id' => 'required|int',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $data = $request->input();
        $data['customer_id'] = \auth()->user()->id;
        $type = $request->input('type');
        $dataResult = $this->tourServices->addNewReply($data);
        return response()->json($dataResult, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addNewReplyByAdmin(Request $request): JsonResponse
    {
        $credentials = $request->only('tour_id', 'description');
        //valid credential
        $validator = Validator::make($credentials, [
            'tour_id' => 'required|int',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiServices->responseBadRequest();
        }
        $data = $request->input();
        $data['user_id'] = \auth()->user()->id;
        $type = $request->input('type');

        $dataResult = $this->tourServices->addNewReply($data);
        return response()->json($dataResult, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteTour($id): JsonResponse
    {

        $dataResult = $this->tourServices->deleteTour($id);
        return response()->json($dataResult, 200);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function getListReply($id): JsonResponse
    {
        $dataResult = $this->tourServices->getListReply($id);
        return response()->json($dataResult, 200);
    }


}
