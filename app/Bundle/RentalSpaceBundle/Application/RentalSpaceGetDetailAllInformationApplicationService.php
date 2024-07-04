<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;
use Illuminate\Support\Facades\Storage;

final class RentalSpaceGetDetailAllInformationApplicationService
{
    /**
     * Rental Space Repository
     *
     * @var IRentalSpaceRepository
     */
    private IRentalSpaceRepository $rentalSpaceRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRepository $rentalSpaceRepository
    )
    {
        $this->rentalSpaceRepository = $rentalSpaceRepository;
    }

    /**
     * @throws RecordNotFoundException
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceGetDetailAllInformationCommand $command): RentalSpaceGetDetailAllInformationResult
    {
        $rentalSpace = $this->rentalSpaceRepository->findById(new RentalSpaceId($command->rentalSpaceId));

        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $rentalSpace = new RentalSpaceGetAllInformationResult(
            $this->generalInformationResult($rentalSpace->getRentalSpaceGeneral()),
            $this->imageInformationResult($rentalSpace->getRentalSpaceImage()),
            $this->equipmentInformationResult($rentalSpace->getRentalSpaceEquipmentInformation()),
            $this->planAndIntervalInformation($rentalSpace->getRentalSpacePlanAndInterval()),
            $this->pageInformationResult($rentalSpace->getRentalSpacePage()),
            $this->emailMessageInformationResult($rentalSpace->getRentalSpaceEmailMessage()),
            $this->imageInformationResult($rentalSpace->getRentalSpacePanoramaImage()),
            $this->imageInformationResult($rentalSpace->getRentalSpaceFacadeImage()),
            $this->imageInformationResult($rentalSpace->getRentalSpaceDirectionsStationImage()),
            $this->imageInformationResult($rentalSpace->getRentalSpaceFloorPlanImage())
        );

        return new RentalSpaceGetDetailAllInformationResult(
            new RentalSpaceId($command->rentalSpaceId),
            $rentalSpace
        );
    }

    /**
     * Rental Space General Result
     */
    private function generalInformationResult($generals)
    {
        if (empty($generals)) {
            return null;
        }
        $generalBasicSpacePurposeOfUses = [];
        foreach ($generals->getGeneralBasicSpacePurposeOfUses() as $spacePurposeOfUse) {
            $generalBasicSpacePurposeOfUses[] = $spacePurposeOfUse;
        }

        $generalSpaceInformationCancellationFeeRules = [];
        if ($generals->getGeneralSpaceInformationCancellationFeeRules() !== null) {
            foreach ($generals->getGeneralSpaceInformationCancellationFeeRules() as $cancellationFeeRule) {
                $generalSpaceInformationCancellationFeeRules[] = $cancellationFeeRule;
            }
        }

        return new RentalSpaceGetDetailGeneralResult(
            $generals->getOrganizationId(),
            $generals->getGeneralBasicSpaceNameJa(),
            $generals->getGeneralBasicSpaceNameKana(),
            $generals->getGeneralBasicSpaceOverview(),
            $generals->getGeneralBasicSpaceIntroduction(),
            $generalBasicSpacePurposeOfUses,
            $generals->getGeneralLocationPostCode(),
            $generals->getGeneralLocationPrefecture(),
            $generals->getGeneralLocationMunicipality(),
            $generals->getGeneralLocationAddressJa(),
            $generals->getGeneralLocationAccessInstructionJa(),
            $generals->getGeneralLocationLatitude(),
            $generals->getGeneralLocationLongitude(),
            $generals->getGeneralSpaceInformationMinimumCapacity(),
            $generals->getGeneralSpaceInformationMaximumCapacity(),
            $generals->getGeneralSpaceInformationSpaciousnessDescriptionJa(),
            $generals->getGeneralSpaceInformationPlanJa(),
            $generals->getGeneralSpaceInformationMovie(),
            $generals->getGeneralSpaceInformationMinimumDurationMinutes(),
            $generals->getGeneralSpaceInformationMaximumBudget(),
            $generals->getGeneralSpaceInformationCheapestPriceGuarantee(),
            $generals->getGeneralSpaceInformationTermsOfService(),
            $generals->getGeneralSpaceInformationCancellationPolicy(),
            $generalSpaceInformationCancellationFeeRules,
            $generals->getGeneralContactOperatingCompanyJa(),
            $generals->getGeneralContactPersonInChargeJa(),
            $generals->getGeneralContactPhoneNumberJa(),
            $generals->getGeneralContactEmail()
        );
    }

    /**
     * Rental Space Image Value
     * @param $images
     * @return array|null
     */
    private function imageInformationResult($images): ?array
    {
        if (empty($images)) {
            return null;
        }
        $imageFiles = [];
        foreach ($images as $imageFile) {
            $imageFiles[] = new RentalSpaceImageValueCommand(
                $imageFile->getImageId(),
                Storage::url($imageFile->getPathImage()),
                $imageFile->getTitleImage(),
                $imageFile->getType()->getValue(),
                $imageFile->getWidth(),
                $imageFile->getHeight(),
                $imageFile->getLength(),
                $imageFile->getExtension(),
                $imageFile->getOrderNumber()
            );
        }
        return $imageFiles;
    }

    /**
     * Get space equipment
     */
    private function equipmentInformationResult($equipments)
    {
        if (empty($equipments)) {
            return null;
        }
        $rentalSpaceEquipmentBasicInformation = [
            'bringing_in_food_and_drink' => $equipments->getEquipmentBasicInformation()->getBringingInFoodAndDrink(),
            'smoking' => $equipments->getEquipmentBasicInformation()->getSmoking(),
            'parking' => $equipments->getEquipmentBasicInformation()->getParking(),
            'number_of_parking_lot' => $equipments->getEquipmentBasicInformation()->getNumberOfParkingLot(),
            'neighborhood_pay_parking' => $equipments->getEquipmentBasicInformation()->getNeighborhoodPayParking(),
            'distance_to_paid_parking' => $equipments->getEquipmentBasicInformation()->getDistanceToPaidParking(),
            'flow_to_use' => $equipments->getEquipmentBasicInformation()->getFlowToUse(),
            'luggage_storage_support' => $equipments->getEquipmentBasicInformation()->getLuggageStorageSupport(),
            'takkyubin_receipt_correspondence' => $equipments->getEquipmentBasicInformation()->getTakkyubinReceiptCorrespondence(),
            'number_of_table' => $equipments->getEquipmentBasicInformation()->getNumberOfTable(),
            'preview_support' => $equipments->getEquipmentBasicInformation()->getPreviewSupport(),
            'number_of_sofa_seat' => $equipments->getEquipmentBasicInformation()->getNumberOfSofaSeat(),
            'commercial_use' => $equipments->getEquipmentBasicInformation()->getCommercialUse(),
            'accompanied_by_pet' => $equipments->getEquipmentBasicInformation()->getAccompaniedByPet(),
            'staff_resident' => $equipments->getEquipmentBasicInformation()->getStaffResident(),
            'affiliated_restaurant' => $equipments->getEquipmentBasicInformation()->getAffiliatedRestaurant(),
            'affiliated_parking_lot' => $equipments->getEquipmentBasicInformation()->getAffiliatedParkingLot(),
            'barrier_free' => $equipments->getEquipmentBasicInformation()->getBarrierFree(),
            'peripheral_convenience_store' => $equipments->getEquipmentBasicInformation()->getPeripheralConvenienceStore(),
            'distance_to_convenience_store' => $equipments->getEquipmentBasicInformation()->getDistanceToConvenienceStore(),
            'surrounding_supermarket' => $equipments->getEquipmentBasicInformation()->getSurroundingSupermarket(),
            'distance_to_supermarket' => $equipments->getEquipmentBasicInformation()->getDistanceToTheSupermarket(),
            'beverage_vending_machine' => $equipments->getEquipmentBasicInformation()->getBeverageVendingMachine(),
            'tobacco_vending_machine' => $equipments->getEquipmentBasicInformation()->getTobaccoVendingMachine(),
            'other' => $equipments->getEquipmentBasicInformation()->getOther(),
            'number_of_chairs' => $equipments->getEquipmentBasicInformation()->getNumberOfChairs(),
        ];

        $rentalSpaceEquipmentGeneralInformation = [
            'wifi' => $equipments->getEquipmentGeneralInformation()->getWifi(),
            'audio_speaker' => $equipments->getEquipmentGeneralInformation()->getAudioSpeaker(),
            'monitor' => $equipments->getEquipmentGeneralInformation()->getMonitor(),
            'toilet' => $equipments->getEquipmentGeneralInformation()->getToilet(),
            'kitchen' => $equipments->getEquipmentGeneralInformation()->getKitchen(),
            'refrigerator' => $equipments->getEquipmentGeneralInformation()->getRefrigerator(),
            'freezer' => $equipments->getEquipmentGeneralInformation()->getFreezer(),
            'ice_machine' => $equipments->getEquipmentGeneralInformation()->getIceMachine(),
            'air_conditioner' => $equipments->getEquipmentGeneralInformation()->getAirConditioner(),
            'elevator' => $equipments->getEquipmentGeneralInformation()->getElevator(),
            'tvSet' => $equipments->getEquipmentGeneralInformation()->getTvSet(),
            'sound_proofing_equipment' => $equipments->getEquipmentGeneralInformation()->getSoundProofingEquipment(),
            'karaoke' => $equipments->getEquipmentGeneralInformation()->getKaraoke(),
            'microphone' => $equipments->getEquipmentGeneralInformation()->getMicrophone(),
            'projector' => $equipments->getEquipmentGeneralInformation()->getProjector(),
            'DVDPlayer' => $equipments->getEquipmentGeneralInformation()->getDVDPlayer()
        ];

        $rentalSpaceEquipmentConferenceInformation = [
            'whiteboard' => $equipments->getEquipmentConferenceInformation()->getWhiteboard(),
            'copier_or_multifunction_machine' => $equipments->getEquipmentConferenceInformation()->getCopierOrMultifunctionMachine(),
            'moderator' => $equipments->getEquipmentConferenceInformation()->getModerator()
        ];

        $rentalSpaceEquipmentShootingInformation = [
            'bar_counter' => $equipments->getEquipmentShootingInformation()->getBarCounter(),
            'garden_or_lawn' => $equipments->getEquipmentShootingInformation()->getGardenOrLawn(),
            'bathtub' => $equipments->getEquipmentShootingInformation()->getBathtub(),
            'spiral_staircase' => $equipments->getEquipmentShootingInformation()->getSpiralStaircase(),
            'atrium' => $equipments->getEquipmentShootingInformation()->getAtrium(),
            'hearth' => $equipments->getEquipmentShootingInformation()->getHearth(),
            'japanese_style_room' => $equipments->getEquipmentShootingInformation()->getJapaneseStyleRoom(),
            'balcony' => $equipments->getEquipmentShootingInformation()->getBalcony(),
            'veranda' => $equipments->getEquipmentShootingInformation()->getVeranda(),
            'rooftop' => $equipments->getEquipmentShootingInformation()->getRooftop(),
            'bullback_shooting' => $equipments->getEquipmentShootingInformation()->getBullbackShooting(),
            'r_horizont' => $equipments->getEquipmentShootingInformation()->getRHorizont(),
            'white_horizont' => $equipments->getEquipmentShootingInformation()->getWhiteHorizont(),
            'bird_eye_view_shooting' => $equipments->getEquipmentShootingInformation()->getBirdEyeViewShooting(),
            'ancillary_services' => $equipments->getEquipmentShootingInformation()->getAncillaryServices(),
            'reflector' => $equipments->getEquipmentShootingInformation()->getReflector(),
            'tripod' => $equipments->getEquipmentShootingInformation()->getTripod(),
            'electric_capacity' => $equipments->getEquipmentShootingInformation()->getElectricCapacity(),
            'electric_capacity_type' => $equipments->getEquipmentShootingInformation()->getElectricCapacityType(),
            'pool' => $equipments->getEquipmentShootingInformation()->getPool(),
            'terrace' => $equipments->getEquipmentShootingInformation()->getTerrace(),
            'lighting_spotlight' => $equipments->getEquipmentShootingInformation()->getLightingSpotlight(),
            'waiting_room_or_makeup_room' => $equipments->getEquipmentShootingInformation()->getWaitingRoomOrMakeupRoom(),
            'large_parking_lot' => $equipments->getEquipmentShootingInformation()->getLargeParkingLot()
        ];

        $rentalSpaceEquipmentEventInformation = [
            'rental_shoes' => $equipments->getEquipmentEventInformation()->getRentalShoes(),
            'yoga_mat' => $equipments->getEquipmentEventInformation()->getYogaMat(),
            'wall_mirrored' => $equipments->getEquipmentEventInformation()->getWallMirrored(),
            'dj_booth' => $equipments->getEquipmentEventInformation()->getDJBooth(),
            'drum_set' => $equipments->getEquipmentEventInformation()->getDrumSet(),
            'piano' => $equipments->getEquipmentEventInformation()->getPiano(),
            'shower_room' => $equipments->getEquipmentEventInformation()->getShowerRoom(),
            'fullLength_mirror' => $equipments->getEquipmentEventInformation()->getFullLengthMirror(),
            'stage' => $equipments->getEquipmentEventInformation()->getStage()
        ];

        $rentalSpaceEquipmentPartyInformation = [
            'bbq_stove' => $equipments->getEquipmentPartyInformation()->getBBQStove(),
            'wine_cellar' => $equipments->getEquipmentPartyInformation()->getWineCellar(),
            'toaster' => $equipments->getEquipmentPartyInformation()->getToaster(),
            'coffee_maker' => $equipments->getEquipmentPartyInformation()->getCoffeeMaker(),
            'rice_cooker' => $equipments->getEquipmentPartyInformation()->getRiceCooker(),
            'oven' => $equipments->getEquipmentPartyInformation()->getOven(),
            'microwave' => $equipments->getEquipmentPartyInformation()->getMicrowave(),
            'grilled_fish' => $equipments->getEquipmentPartyInformation()->getGrilledFish(),
            'frying_pan' => $equipments->getEquipmentPartyInformation()->getFryingPan(),
            'pot' => $equipments->getEquipmentPartyInformation()->getPot(),
            'kitchen_knife' => $equipments->getEquipmentPartyInformation()->getKitchenKnife(),
            'stove' => $equipments->getEquipmentPartyInformation()->getStove(),
            'cutlery' => $equipments->getEquipmentPartyInformation()->getCutlery(),
            'chopsticks' => $equipments->getEquipmentPartyInformation()->getChopsticks(),
            'glass' => $equipments->getEquipmentPartyInformation()->getGlass(),
            'plate' => $equipments->getEquipmentPartyInformation()->getPlate(),
            'part_game' => $equipments->getEquipmentPartyInformation()->getPartGame()
        ];

        $rentalSpaceEquipmentShareInformation = [
            'waterServer' => $equipments->getEquipmentShareInformation()->getWaterServer(),
            'treatmentTable' => $equipments->getEquipmentShareInformation()->getTreatmentTable()
        ];

        return new RentalSpaceGetDetailEquipmentInformationResult(
            $equipments->getRentalSpaceId()->getValue(),
            $rentalSpaceEquipmentBasicInformation,
            $rentalSpaceEquipmentGeneralInformation,
            $rentalSpaceEquipmentConferenceInformation,
            $rentalSpaceEquipmentShootingInformation,
            $rentalSpaceEquipmentEventInformation,
            $rentalSpaceEquipmentPartyInformation,
            $rentalSpaceEquipmentShareInformation
        );
    }

    /**
     * Plan And Interval Information
     */
    private function planAndIntervalInformation($intervals)
    {
        if (empty($intervals)) {
            return null;
        }
        $response = [];
        foreach ($intervals as $interval) {
            $rentalIntervals = [];
            foreach ($interval['rentalIntervals'] as $intervalInformation) {
                $rentalIntervals[] = new RentalSpaceRentalIntervalResult(
                    $intervalInformation->getId(),
                    $intervalInformation->getApplicabilityPeriods(),
                    $intervalInformation->getEndTimeFormatted(),
                    $intervalInformation->getStartTimeFormatted(),
                    RentalSpaceRentalIntervalHolidayApplicabilityType::fromValue($intervalInformation->getHolidayApplicabilityType())->getType(),
                    $intervalInformation->getStatus(),
                    $intervalInformation->getTenancyPrice(),
                    $intervalInformation->getTenancyPriceWithFraction(),
                    $intervalInformation->getPerPersonPrice(),
                    $intervalInformation->getPerPersonPriceWithFraction(),
                    $intervalInformation->getMaxSimultaneousReservations(),
                    $intervalInformation->getMaxSimultaneousPeople()
                );
            }
            $response[] = new RentalSpaceGetDetailRentalSpaceIntervalResult(
                $interval['rentalPlanId'],
                $interval['rentalPlanName'],
                [],
                $rentalIntervals
            );
        }
        return $response;
    }

    /**
     * Page Information
     */
    private function pageInformationResult($pages)
    {
        if (empty($pages)) {
            return null;
        }

        $results = [];
        foreach ($pages as $page) {
            $results[] = new RentalSpacePageAndEmailMessageObjectResult(
                $page->getId()->getValue(),
                $page->getTitle(),
                $page->getContent()
            );
        }
        return $results;
    }

    /**
     * Email Message Information
     */
    private function emailMessageInformationResult($emailMessage)
    {
        if (empty($emailMessage)) {
            return null;
        }

        $results = [];
        foreach ($emailMessage as $value) {
            $results[] = new RentalSpacePageAndEmailMessageObjectResult(
                $value->getId()->getValue(),
                $value->getTitle(),
                $value->getContent()
            );
        }
        return $results;
    }
}
