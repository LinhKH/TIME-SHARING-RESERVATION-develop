<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetCurrentDraftStepApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetCurrentDraftStepCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailGeneralApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailGeneralCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceListGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceListGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostGeneralApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGeneralCancellationFeeRuleCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostGeneralCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGeneralPurposeOfUseCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutGeneralApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutGeneralCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\SystemConfigRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalPlanRepository;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceGeneralRequest;
use App\Http\Requests\RentalSpaceUpdateTsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalSpaceGeneralController extends Controller
{
    /**
     * Get all rental space
     * @param Request $request
     * @return JsonResponse
     */
    public function getRentalSpaceManage(Request $request): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $applicationService = new RentalSpaceListGetApplicationService(
            $rentalSpaceGeneralRepository
        );

        $command = new RentalSpaceListGetCommand(
            !empty($request['page']) ? (int)$request['page'] : 1,
        );

        $rentalSpaceResults = $applicationService->handle($command, $request->all());

        $data = [];
        foreach ($rentalSpaceResults->rentalSpaces as $rentalSpaceResult) {
            $data[] = [
                'id' => $rentalSpaceResult->id,
                'organization_id' => $rentalSpaceResult->organizationId,
                'organization_information' => [
                    'name' => $rentalSpaceResult->organizationInformation->name,
                    'name_furigana' => $rentalSpaceResult->organizationInformation->nameFurigana
                ],
                'status' => $rentalSpaceResult->status,
                'title' => $rentalSpaceResult->title,
                'draft-step' => $rentalSpaceResult->draftStep
            ];
        }

        $response = [
            'data' => $data,
            'pagination' => [
                'total' => $rentalSpaceResults->pagination->totalPage,
                'per_page' => $rentalSpaceResults->pagination->perPage,
                'current_page' => $rentalSpaceResults->pagination->currentPage,
            ],
        ];

        return response()->json($response);
    }

    /**
     * @param int $id
     * @param RentalSpaceUpdateTsRequest $request
     *
     * @return JsonResponse
     */
    public function handleUpdateInfoRentalSpace(RentalSpaceUpdateTsRequest $request, int $id): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $res = $rentalSpaceGeneralRepository->handleUpdateInfoRentalSpaceEav($id, $request->all());

        return response()->json($res, 200);
    }

    /**
     * Create General
     *
     * @param RentalSpaceGeneralRequest $request
     * @return JsonResponse
     * @throws TransactionException
     * @throws InvalidArgumentException
     */

    public function postRentalSpaceGeneral(RentalSpaceGeneralRequest $request): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $postRentalSpaceGeneralApplicationService = new RentalSpacePostGeneralApplicationService(
            $rentalSpaceGeneralRepository
        );
        
        $generalBasicSpacePurposeOfUsesCommand = [];
        if (!empty($request->general_basic_space_purpose_of_uses)) {
            foreach ($request->general_basic_space_purpose_of_uses as $generalBasicSpacePurposeOfUseRequest) {
                $generalBasicSpacePurposeOfUsesCommand[] = new RentalSpaceGeneralPurposeOfUseCommand(
                    $generalBasicSpacePurposeOfUseRequest['main_category'],
                    $generalBasicSpacePurposeOfUseRequest['sub_category']?? '',
                    $generalBasicSpacePurposeOfUseRequest['title_category'] ?? null
                );
            }
        }
        // dd($rentalSpaceGeneralRepository);
        

        $generalSpaceInformationCancellationFeeRulesCommand = [];
        if (!empty($request->general_space_information_cancellation_fee_rules)) {
            foreach ($request->general_space_information_cancellation_fee_rules as $generalSpaceInformationCancellationFeeRuleRequest) {
                $generalSpaceInformationCancellationFeeRulesCommand[] = new RentalSpaceGeneralCancellationFeeRuleCommand(
                    $generalSpaceInformationCancellationFeeRuleRequest['start_day'],
                    $generalSpaceInformationCancellationFeeRuleRequest['end_day'],
                    $generalSpaceInformationCancellationFeeRuleRequest['percentage'],
                    $generalSpaceInformationCancellationFeeRuleRequest['is_coupon_applicable']
                );
            }
        }

        $command = new RentalSpacePostGeneralCommand(
            $request->organization_id,
            $request->general_basic_space_name_ja,
            $request->general_basic_space_name_kana,
            $request->general_basic_space_overview,
            $request->general_basic_space_introduction,
            $generalBasicSpacePurposeOfUsesCommand,

            $request->general_location_post_code,
            $request->general_location_prefecture,
            $request->general_location_municipality,
            $request->general_location_address_ja,
            $request->general_location_access_instruction_ja,
            $request->general_location_latitude,
            $request->general_location_longitude,

            $request->general_space_information_minimum_capacity,
            $request->general_space_information_maximum_capacity,
            $request->general_space_information_spaciousness_description_ja,
            $request->general_space_information_plan_ja,
            $request->general_space_information_movie,
            $request->general_space_information_minimum_duration_minutes,
            $request->general_space_information_maximum_budget,
            $request->general_space_information_cheapest_price_guarantee,
            $request->general_space_information_terms_of_service,
            $request->general_space_information_cancellation_policy,
            $generalSpaceInformationCancellationFeeRulesCommand,

            $request->general_contact_operating_company_ja,
            $request->general_contact_person_in_charge_ja,
            $request->general_contact_phone_number_ja,
            $request->general_contact_email
        );

        $rentalSpace = $postRentalSpaceGeneralApplicationService->handle($command);
        
        if (!empty($rentalSpace->rentalSpaceId)) {
            $rentalSpaceGeneralRepository->handleUpdateUserIdOnRentalSpace($rentalSpace->rentalSpaceId, auth()->user()->id);
        }

        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];

        return response()->json($response, 200);
    }


    /**
     * Get Detail Rental Space - General
     */
    public function detailRentalSpaceGeneral($rentalSpaceId): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $getRentalSpaceDetailGeneralApplicationService = new RentalSpaceGetDetailGeneralApplicationService(
            $rentalSpaceGeneralRepository
        );

        $command = new RentalSpaceGetDetailGeneralCommand($rentalSpaceId);
        $generals = $getRentalSpaceDetailGeneralApplicationService->handle($command);

        $response = [
            'organization_id' => $generals->organizationId,
            'general_basic_space_name_ja' => $generals->generalBasicSpaceNameJa,
            'general_basic_space_name_kana' => $generals->generalBasicSpaceNameKana,
            'general_basic_space_overview' => $generals->generalBasicSpaceOverview,
            'general_basic_space_introduction' => $generals->generalBasicSpaceIntroduction,
            'general_basic_space_purpose_of_uses' => $generals->generalBasicSpacePurposeOfUses,

            'general_location_post_code' => $generals->generalLocationPostCode,
            'general_location_prefecture' => $generals->generalLocationPrefecture,
            'general_location_municipality' => $generals->generalLocationMunicipality,
            'general_location_address_ja' => $generals->generalLocationAddressJa,
            'general_location_access_instruction_ja' => $generals->generalLocationAccessInstructionJa,
            'general_location_latitude' => $generals->generalLocationLatitude,
            'general_location_longitude' => $generals->generalLocationLongitude,

            'general_space_information_minimum_capacity' => $generals->generalSpaceInformationMinimumCapacity,
            'general_space_information_maximum_capacity' => $generals->generalSpaceInformationMaximumCapacity,
            'general_space_information_spaciousness_description_ja' => $generals->generalSpaceInformationSpaciousnessDescriptionJa,
            'general_space_information_plan_ja' => $generals->generalSpaceInformationPlanJa,
            'general_space_information_movie' => $generals->generalSpaceInformationMovie,
            'general_space_information_minimum_duration_minutes' => $generals->generalSpaceInformationMinimumDurationMinutes,
            'general_space_information_maximum_budget' => $generals->generalSpaceInformationMaximumBudget,
            'general_space_information_cheapest_price_guarantee' => $generals->generalSpaceInformationCheapestPriceGuarantee,
            'general_space_information_terms_of_service' => $generals->generalSpaceInformationTermsOfService,
            'general_space_information_cancellation_policy' => $generals->generalSpaceInformationCancellationPolicy,
            'general_space_information_cancellation_fee_rules' => $generals->generalSpaceInformationCancellationFeeRules,

            'general_contact_operating_company_ja' => $generals->generalContactOperatingCompanyJa,
            'general_contact_person_in_charge_ja' => $generals->generalContactPersonInChargeJa,
            'general_contact_phone_number_ja' => $generals->generalContactPhoneNumberJa,
            'general_contact_email' => $generals->generalContactEmail
        ];

        $response['status'] = $rentalSpaceGeneralRepository->getStatusSpace($rentalSpaceId);

        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * API get current draft step
     */
    public function getCurrentStep($rentalSpaceId): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $draftStepApplicationService = new RentalSpaceGetCurrentDraftStepApplicationService(
            $rentalSpaceGeneralRepository,
            $rentalSpaceRentalPlanRepository
        );
        $systemConfigRepository = new SystemConfigRepository();
        $applicationService = new SystemConfigGetApplicationService(
            $systemConfigRepository
        );
        $commandSystem = new SystemConfigGetCommand(null);
        $command = new RentalSpaceGetCurrentDraftStepCommand($rentalSpaceId);
        $currentDraftStep = $draftStepApplicationService->handle($command);
        $result = $applicationService->handle($commandSystem);

        $response = [
            'id' => $currentDraftStep->rentalSpaceId,
            'max_rental_plans_count' => $result->maxRentalPlansCount,
            'current_draft_step' => $currentDraftStep->draftStep,
            'is_approval' => $currentDraftStep->isApproval
        ];
        if (!empty($currentDraftStep->rentalPlanId)) {
            $response['rental_plan_id'] = $currentDraftStep->rentalPlanId;
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * API Update general information of Space
     *
     */
    public function updateRentalSpaceGeneral($rentalSpaceId, RentalSpaceGeneralRequest $request): JsonResponse
    {
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $updateRentalSpaceGeneralApplicationService = new RentalSpacePutGeneralApplicationService(
            $rentalSpaceGeneralRepository
        );

        $generalBasicSpacePurposeOfUsesCommand = [];
        if (!empty($request->general_basic_space_purpose_of_uses)) {
            foreach ($request->general_basic_space_purpose_of_uses as $generalBasicSpacePurposeOfUseRequest) {
                $generalBasicSpacePurposeOfUsesCommand[] = new RentalSpaceGeneralPurposeOfUseCommand(
                    $generalBasicSpacePurposeOfUseRequest['main_category'],
                    $generalBasicSpacePurposeOfUseRequest['sub_category'],
                    $generalBasicSpacePurposeOfUseRequest['title_category'] ?? null
                );
            }
        }

        $generalSpaceInformationCancellationFeeRulesCommand = [];
        if (!empty($request->general_space_information_cancellation_fee_rules)) {
            foreach ($request->general_space_information_cancellation_fee_rules as $generalSpaceInformationCancellationFeeRuleRequest) {
                $generalSpaceInformationCancellationFeeRulesCommand[] = new RentalSpaceGeneralCancellationFeeRuleCommand(
                    $generalSpaceInformationCancellationFeeRuleRequest['start_day'],
                    $generalSpaceInformationCancellationFeeRuleRequest['end_day'],
                    $generalSpaceInformationCancellationFeeRuleRequest['percentage'],
                    $generalSpaceInformationCancellationFeeRuleRequest['is_coupon_applicable']
                );
            }
        }

        $command = new RentalSpacePutGeneralCommand(
            $rentalSpaceId,
            $request->organization_id,
            $request->general_basic_space_name_ja,
            $request->general_basic_space_name_kana,
            $request->general_basic_space_overview,
            $request->general_basic_space_introduction,
            $generalBasicSpacePurposeOfUsesCommand,

            $request->general_location_post_code,
            $request->general_location_prefecture,
            $request->general_location_municipality,
            $request->general_location_address_ja,
            $request->general_location_access_instruction_ja,
            $request->general_location_latitude,
            $request->general_location_longitude,

            $request->general_space_information_minimum_capacity,
            $request->general_space_information_maximum_capacity,
            $request->general_space_information_spaciousness_description_ja,
            $request->general_space_information_plan_ja,
            $request->general_space_information_movie,
            $request->general_space_information_minimum_duration_minutes,
            $request->general_space_information_maximum_budget,
            $request->general_space_information_cheapest_price_guarantee,
            $request->general_space_information_terms_of_service,
            $request->general_space_information_cancellation_policy,
            $generalSpaceInformationCancellationFeeRulesCommand,

            $request->general_contact_operating_company_ja,
            $request->general_contact_person_in_charge_ja,
            $request->general_contact_phone_number_ja,
            $request->general_contact_email
        );

        $rentalSpace = $updateRentalSpaceGeneralApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId
        ];
        return response()->json($response, 200);
    }
}
