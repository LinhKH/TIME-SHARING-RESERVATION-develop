<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceEquipmentInformationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailEquipmentInformationApplicationService
{
    /**
     * RentalSpaceEquipmentInformationRepository
     *
     * @var IRentalSpaceEquipmentInformationRepository
     */
    private IRentalSpaceEquipmentInformationRepository $rentalSpaceEquipmentInformationRepository;


    /**
     *
     */
    public function __construct(
        IRentalSpaceEquipmentInformationRepository $rentalSpaceEquipmentInformationRepository
    )
    {
        $this->rentalSpaceEquipmentInformationRepository = $rentalSpaceEquipmentInformationRepository;

    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailEquipmentInformationCommand $command): RentalSpaceGetDetailEquipmentInformationResult
    {
        $equipments = $this->rentalSpaceEquipmentInformationRepository->findById(new RentalSpaceId($command->rentalSpaceId));

        if (!$equipments) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
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
}
