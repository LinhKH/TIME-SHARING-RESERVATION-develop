<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailAllInformationApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailAllInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetSearchAndSortCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceApprovalRepository;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailApprovalCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailApprovalApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailReservationOptionTypeApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailReservationOptionTypeCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceReservationOptionTypeRepository;
use App\Http\Controllers\Controller;
use App\Services\ReservationServices;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceRentalPlanController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\NearTransportationController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentalSpaceController extends Controller
{
    private ReservationServices $reservationServices;

    public function __construct(ReservationServices $reservationServices)
    {
        $this->reservationServices = $reservationServices;
    }

    /**
     * Get List Rental Space FE
     */
    public function getListRentalSpaceFE(Request $request)
    {
        $rentalSpaceRepository = new RentalSpaceRepository();
        $response = $rentalSpaceRepository->getListRentalSpaceFE($request->all());

        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Get List Rental Space By Condition
     */
    public function getListRentalSpaceByCondition(Request $request)
    {
        $rentalSpaceRepository = new RentalSpaceRepository();
        $response = $rentalSpaceRepository->getListRentalSpaceByCondition($request->all());

        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Get Detail Rental Space - All Information
     */
    public function detailRentalSpaceManage($rentalSpaceId): JsonResponse
    {
        $rentalSpaceRepository = new RentalSpaceRepository();
        $getRentalSpaceDetailApplicationService = new RentalSpaceGetDetailAllInformationApplicationService(
            $rentalSpaceRepository
        );
        $rentalSpaceApprovalRepository = new RentalSpaceApprovalRepository();
        $command = new RentalSpaceGetDetailAllInformationCommand($rentalSpaceId);
        $rentalSpaceInformation = $getRentalSpaceDetailApplicationService->handle($command);
        $detailRentalSpaceApprovalApplicationService = new RentalSpaceGetDetailApprovalApplicationService(
            $rentalSpaceApprovalRepository
        );
        $command1 = new RentalSpaceGetDetailApprovalCommand($rentalSpaceId);
        $newTransportation = new NearTransportationController();
        $approval = $detailRentalSpaceApprovalApplicationService->handle($command1);

        $response = [
            'rental_space_id' => $rentalSpaceInformation->rentalSpaceId->getValue(),
            'tag' => $rentalSpaceRepository->getDataTag($rentalSpaceInformation->rentalSpaceId->getValue()),
            'areas' => $rentalSpaceRepository->getDataAreas($rentalSpaceInformation->rentalSpaceId->getValue()),
            'category_spaces' => $rentalSpaceRepository->getDataCategorySpaces($rentalSpaceInformation->rentalSpaceId->getValue()),
            'general' => $this->generalInfromation($rentalSpaceInformation->rentalSpaceInformation->rentalSpaceGeneral),
            'image' => $this->imageValueInformation($rentalSpaceInformation->rentalSpaceInformation->rentalSpaceImages),
            'equipment' => $rentalSpaceInformation->rentalSpaceInformation->rentalSpaceEquipmentInformation,
            'plan' => $this->planAndIntervalInformation($rentalSpaceId, $rentalSpaceInformation->rentalSpaceInformation->rentalSpacePlanAndInterval),
            'page' => $rentalSpaceInformation->rentalSpaceInformation->rentalSpacePage,
            'email_message' => $rentalSpaceInformation->rentalSpaceInformation->rentalSpaceEmailMessage,
            'panorama_image' => $this->imageValueInformation($rentalSpaceInformation->rentalSpaceInformation->rentalSpacePanoramaImages),
            'facade_image' => $this->imageValueInformation($rentalSpaceInformation->rentalSpaceInformation->rentalSpaceFacadeImages),
            'direction_station_image' => $this->imageValueInformation($rentalSpaceInformation->rentalSpaceInformation->rentalSpaceDirectionsStationImages),
            'floor_plan_image' => $this->imageValueInformation($rentalSpaceInformation->rentalSpaceInformation->rentalSpaceFloorPlanImages),
            'near_transporttation' => $newTransportation->getNearTransportation($rentalSpaceId)->original,
            'reservation_option_types' => $this->getReservationOptionTypes($rentalSpaceId),
            'status' => $approval->status
        ];

        if (!empty($response['rental_space_id'])) {
            $response['data_ts_space_eav'] = $this->getInfoTsRentalSpaceEav($response['rental_space_id']);
        }

        return response()->json(['status' => 200, 'data' => $response]);
    }

    private function getReservationOptionTypes($rentalSpaceId)
    {
        $rentalSpaceReservationOptionTypeRepository = new RentalSpaceReservationOptionTypeRepository();
        $detailApplicationService = new RentalSpaceGetDetailReservationOptionTypeApplicationService(
            $rentalSpaceReservationOptionTypeRepository
        );

        $command = new RentalSpaceGetDetailReservationOptionTypeCommand($rentalSpaceId);
        return $detailApplicationService->handle($command);
    }

    private function getPaymentMethodOnRentalSpaceRentalPlanEav($rental_plan_id)
    {
        $rentalSpaceRepository = new RentalSpaceRepository();

        return $rentalSpaceRepository->getPaymentMethodOnRentalSpaceRentalPlanEav($rental_plan_id);
    }

    private function getInfoTsRentalSpaceEav($rental_plan_id)
    {
        $rentalSpaceRepository = new RentalSpaceRepository();

        return $rentalSpaceRepository->getInfoTsRentalSpaceEav($rental_plan_id);
    }

    /**
     * General Information
     */
    private function generalInfromation($generals)
    {
        if (empty($generals)) {
            return [];
        }
        return [
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
    }

    /**
     * Image Value Information
     */
    private function imageValueInformation($images)
    {
        if (empty($images)) {
            return [];
        }
        $imageFiles = [];
        foreach ($images as $imageFile) {
            $imageFiles[] = [
                'id' => $imageFile->imageId,
                'title' => $imageFile->titleImage,
                'height' => $imageFile->height,
                'extension' => $imageFile->extension,
                'length' => $imageFile->length,
                'width' => $imageFile->width,
                'type' => $imageFile->type,
                'path_image' => $imageFile->pathImage,
                'order_number' => $imageFile->orderNumber
            ];
        }
        return $imageFiles;
    }

    /**
     * Plan and Interval
     */
    private function planAndIntervalInformation($rentalSpaceId, $rentalIntervals)
    {
        if (empty($rentalIntervals)) {
            return [];
        }
        $response = [];
        foreach ($rentalIntervals as $interval) {
            $rentalIntervalInformation = [];
            $detailPlan = new RentalSpaceRentalPlanController();
            foreach ($interval->rentalSpaceRentalIntervalResult as $value) {
                $rentalIntervalInformation[] = [
                    'id' => $value->id,
                    'applicability_periods' => $value->applicabilityPeriods,
                    'end_time_formatted' => $value->endTimeFormatted,
                    'start_time_formatted' => $value->startTimeFormatted,
                    'holiday_applicability_type' => $value->holidayApplicabilityType,
                    'status' => $value->status,
                    'tenancy_price' => $value->tenancyPrice,
                    'tenancy_price_with_fraction' => $value->tenancyPriceWithFraction,
                    'per_person_price' => $value->perPersonPrice,
                    'per_person_price_with_fraction' => $value->perPersonPriceWithFraction,
                    'max_simultaneous_reservations' => $value->maxSimultaneousReservations,
                    'max_simultaneous_people' => $value->maxSimultaneousPeople
                ];
            }
            $response[] = [
                'rental_plan_id' => $interval->rentalPlanId,
                'rental_plan_name' => $interval->rentalPlanName,
                'rental_intervals' => $rentalIntervalInformation,
                'rental_detail' => $detailPlan->detailRentalPlan($rentalSpaceId, $interval->rentalPlanId)->original
            ];
        }
        return $response;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function isCheckUsingSpace($id): JsonResponse
    {
        $response = $this->reservationServices->isCheckUsingSpace($id);
        return response()->json($response, 200);
    }


    public function searchAndSortAction(Request $request)
    {
        $command = new RentalSpaceGetSearchAndSortCommand();
    }
}
