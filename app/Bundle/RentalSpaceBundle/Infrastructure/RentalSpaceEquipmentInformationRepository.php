<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceEquipmentInformationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentBasicInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentConferenceInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentEventInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentGeneralInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentPartyInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShareInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShootingInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceTypeDataEav;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;

class RentalSpaceEquipmentInformationRepository implements IRentalSpaceEquipmentInformationRepository
{

    /**
     * @param RentalSpace $rentalSpace
     * @return array
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function createRentalSpaceEquipmentInformation(RentalSpace $rentalSpace): array
    {
        $dataEav = [
            "equipmentInformation__bringingInFoodAndDrink" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBringingInFoodAndDrink(),
            "equipmentInformation__smoking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getSmoking(),
            "equipmentInformation__parking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getParking(),
            "equipmentInformation__numberOfParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfParkingLot(),
            "equipmentInformation__neighborhoodPayParking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNeighborhoodPayParking(),
            "equipmentInformation__distanceToPaidParking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToPaidParking(),
            "equipmentInformation__flowToUse" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getFlowToUse(),
            "equipmentInformation__luggageStorageSupport" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getLuggageStorageSupport(),
            "equipmentInformation__takkyubinReceiptCorrespondence" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getTakkyubinReceiptCorrespondence(),
            "equipmentInformation__numberOfTable" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfTable(),
            "equipmentInformation__numberOfChair" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfChairs(),
            "equipmentInformation__previewSupport" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getPreviewSupport(),
            "equipmentInformation__numberOfSofaSeat" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfSofaSeat(),
            "equipmentInformation__commercialUse" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getCommercialUse(),
            "equipmentInformation__accompaniedByPet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAccompaniedByPet(),
            "equipmentInformation__staffResident" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getStaffResident(),
            "equipmentInformation__affiliatedRestaurant" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAffiliatedRestaurant(),
            "equipmentInformation__affiliatedParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAffiliatedParkingLot(),
            "equipmentInformation__barrierFree" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBarrierFree(),
            "equipmentInformation__peripheralConvenienceStore" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getPeripheralConvenienceStore(),
            "equipmentInformation__distanceToConvenienceStore" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToConvenienceStore(),
            "equipmentInformation__surroundingSupermarket" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getSurroundingSupermarket(),
            "equipmentInformation__distanceToTheSupermarket" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToTheSupermarket(),
            "equipmentInformation__beverageVendingMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBeverageVendingMachine(),
            "equipmentInformation__tobaccoVendingMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getTobaccoVendingMachine(),
            "equipmentInformation__other" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getOther(),

            "equipmentInformation__wifi" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getWifi(),
            "equipmentInformation__audioSpeaker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getAudioSpeaker(),
            "equipmentInformation__monitor" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getMonitor(),
            "equipmentInformation__toilet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getToilet(),
            "equipmentInformation__kitchen" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getKitchen(),
            "equipmentInformation__refrigerator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getRefrigerator(),
            "equipmentInformation__freezer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getFreezer(),
            "equipmentInformation__iceMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getIceMachine(),
            "equipmentInformation__airConditioner" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getAirConditioner(),
            "equipmentInformation__elevator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getElevator(),
            "equipmentInformation__tvSet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getTvSet(),
            "equipmentInformation__soundProofingEquipment" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getSoundProofingEquipment(),
            "equipmentInformation__karaoke" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getKaraoke(),
            "equipmentInformation__microphone" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getMicrophone(),
            "equipmentInformation__projector" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getProjector(),
            "equipmentInformation__DVDPlayer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getDVDPlayer(),

            "whiteboard" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getWhiteboard(),
            "copierOrMultifunctionMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getCopierOrMultifunctionMachine(),
            "moderator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getModerator(),

            "equipmentInformation__barCounter" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBarCounter(),
            "equipmentInformation__gardenOrLawn" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getGardenOrLawn(),
            "equipmentInformation__bathtub" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBathtub(),
            "equipmentInformation__spiralStaircase" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getSpiralStaircase(),
            "equipmentInformation__atrium" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getAtrium(),
            "equipmentInformation__hearth" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getHearth(),
            "equipmentInformation__japaneseStyleRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getJapaneseStyleRoom(),
            "equipmentInformation__balcony" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBalcony(),
            "equipmentInformation__veranda" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getVeranda(),
            "equipmentInformation__rooftop" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getRooftop(),
            "equipmentInformation__bullbackShooting" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBullbackShooting(),
            "equipmentInformation__R_Horizont" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getRHorizont(),
            "equipmentInformation__whiteHorizont" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getWhiteHorizont(),
            "equipmentInformation__birdEyeViewShooting" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBirdEyeViewShooting(),
            "equipmentInformation__ancillaryServices" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getAncillaryServices(),
            "equipmentInformation__reflector" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getReflector(),
            "equipmentInformation__tripod" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getTripod(),
            "equipmentInformation__electricCapacity" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getElectricCapacity(),
            "equipmentInformation__electricCapacityType" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getElectricCapacityType(),
            "equipmentInformation__largeParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getLargeParkingLot(),
            "equipmentInformation__pool" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getPool(),
            "equipmentInformation__terrace" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getTerrace(),
            "equipmentInformation__lightingSpotlight" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getLightingSpotlight(),
            "equipmentInformation__waitingRoomOrMakeupRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getWaitingRoomOrMakeupRoom(),

            "equipmentInformation__rentalShoes" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getRentalShoes(),
            "equipmentInformation__yogaMat" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getYogaMat(),
            "equipmentInformation__wallMirrored" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getWallMirrored(),
            "equipmentInformation__DJ_Booth" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getDJBooth(),
            "equipmentInformation__drumSet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getDrumSet(),
            "equipmentInformation__piano" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getPiano(),
            "equipmentInformation__showerRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getShowerRoom(),
            "equipmentInformation__fullLengthMirror" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getFullLengthMirror(),
            "equipmentInformation__stage" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getStage(),

            "equipmentInformation__BBQ_Stove" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getBBQStove(),
            "equipmentInformation__wineCellar" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getWineCellar(),
            "equipmentInformation__toaster" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getToaster(),
            "equipmentInformation__coffeeMaker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getCoffeeMaker(),
            "equipmentInformation__riceCooker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getRiceCooker(),
            "equipmentInformation__oven" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getOven(),
            "equipmentInformation__microwave" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getMicrowave(),
            "equipmentInformation__grilledFish" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getGrilledFish(),
            "equipmentInformation__fryingPan" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getFryingPan(),
            "equipmentInformation__pot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPot(),
            "equipmentInformation__kitchenKnife" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getKitchenKnife(),
            "equipmentInformation__stove" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getStove(),
            "equipmentInformation__cutlery" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getCutlery(),
            "equipmentInformation__chopsticks" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getChopsticks(),
            "equipmentInformation__glass" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getGlass(),
            "equipmentInformation__plate" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPlate(),
            "equipmentInformation__partGame" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPartGame(),

            "equipmentInformation__waterServer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShareInformation()->getWaterServer(),
            "equipmentInformation__treatmentTable" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShareInformation()->getTreatmentTable()
        ];

        foreach ($dataEav as $key => $value) {
            if ($value === null) {
                unset($dataEav[$key]);
            } else {
                ModelRentalSpaceEav::create([
                    'namespace' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'attribute' => $key,
                    'value' => $value,
                    'type_step' => "equipment_information"
                ]);
            }
        }
        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();

        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceEquipmentInformation|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceEquipmentInformation
    {
        // TODO: Implement findById() method.
        $space = ModelRentalSpace::find($rentalSpaceId->getValue());
        $entities = ModelRentalSpaceEav::where('namespace', $rentalSpaceId->getValue())->get()->toArray();
        if (!$entities) {
            return null;
        }
        $dataRentalSpaceEav = [];
        foreach ($entities as $entity) {
            $dataRentalSpaceEav[$entity['attribute']] = $entity['value'];
        }

        $rentalSpaceEquipmentBasicInformation = new RentalSpaceEquipmentBasicInformation (
            $dataRentalSpaceEav['equipmentInformation__bringingInFoodAndDrink'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__smoking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__parking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__neighborhoodPayParking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToPaidParking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__flowToUse'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__luggageStorageSupport'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__takkyubinReceiptCorrespondence'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfTable'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfChair'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfSofaSeat'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__previewSupport'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__commercialUse'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__accompaniedByPet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__staffResident'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__affiliatedRestaurant'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__affiliatedParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__barrierFree'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__peripheralConvenienceStore'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToConvenienceStore'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__surroundingSupermarket'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToTheSupermarket'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__beverageVendingMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tobaccoVendingMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__other'] ?? null
        );

        $rentalSpaceEquipmentGeneralInformation = new RentalSpaceEquipmentGeneralInformation(
            $dataRentalSpaceEav['equipmentInformation__wifi'],
            $dataRentalSpaceEav['equipmentInformation__audioSpeaker'],
            $dataRentalSpaceEav['equipmentInformation__monitor'],
            $dataRentalSpaceEav['equipmentInformation__toilet'],
            $dataRentalSpaceEav['equipmentInformation__kitchen'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__refrigerator'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__freezer'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__iceMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__airConditioner'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__elevator'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tvSet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__soundProofingEquipment'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__karaoke'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__microphone'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__DVDPlayer'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__projector'] ?? null
        );

        $rentalSpaceEquipmentConferenceInformation = new RentalSpaceEquipmentConferenceInformation(
            $dataRentalSpaceEav['whiteboard'] ?? null,
            $dataRentalSpaceEav['copierOrMultifunctionMachine'] ?? null,
            $dataRentalSpaceEav['moderator'] ?? null
        );

        $rentalSpaceEquipmentShootingInformation = new RentalSpaceEquipmentShootingInformation(
            $dataRentalSpaceEav['equipmentInformation__waitingRoomOrMakeupRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__lightingSpotlight'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__terrace'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__pool'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__electricCapacityType'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__electricCapacity'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__largeParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tripod'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__reflector'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__ancillaryServices'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__birdEyeViewShooting'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__whiteHorizont'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__R_Horizont'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__bullbackShooting'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__rooftop'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__veranda'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__balcony'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__japaneseStyleRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__hearth'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__atrium'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__spiralStaircase'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__bathtub'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__gardenOrLawn'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__barCounter'] ?? null
        );

        $rentalSpaceEquipmentEventInformation = new RentalSpaceEquipmentEventInformation(
            $dataRentalSpaceEav['equipmentInformation__stage'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__fullLengthMirror'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__showerRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__piano'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__drumSet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__DJ_Booth'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__wallMirrored'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__yogaMat'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__rentalShoes'] ?? null
        );

        $rentalSpaceEquipmentPartyInformation = new RentalSpaceEquipmentPartyInformation(
            $dataRentalSpaceEav['equipmentInformation__partGame'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__plate'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__glass'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__chopsticks'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__cutlery'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__stove'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__kitchenKnife'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__microwave'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__fryingPan'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__pot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__grilledFish'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__oven'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__riceCooker'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__coffeeMaker'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__toaster'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__wineCellar'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__BBQ_Stove'] ?? null
        );
        $rentalSpaceEquipmentShareInformation = new RentalSpaceEquipmentShareInformation(
            $dataRentalSpaceEav['equipmentInformation__treatmentTable'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__waterServer'] ?? null
        );

        return new RentalSpaceEquipmentInformation(
            new RentalSpaceId($space->organization_id),
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
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceId
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function updateRentalSpaceEquipmentInformation(RentalSpace $rentalSpace): RentalSpaceId
    {
        $dataEav = [
            "equipmentInformation__bringingInFoodAndDrink" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBringingInFoodAndDrink(),
            "equipmentInformation__smoking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getSmoking(),
            "equipmentInformation__parking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getParking(),
            "equipmentInformation__numberOfParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfParkingLot(),
            "equipmentInformation__neighborhoodPayParking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNeighborhoodPayParking(),
            "equipmentInformation__distanceToPaidParking" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToPaidParking(),
            "equipmentInformation__flowToUse" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getFlowToUse(),
            "equipmentInformation__luggageStorageSupport" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getLuggageStorageSupport(),
            "equipmentInformation__takkyubinReceiptCorrespondence" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getTakkyubinReceiptCorrespondence(),
            "equipmentInformation__numberOfTable" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfTable(),
            "equipmentInformation__numberOfChair" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfChairs(),
            "equipmentInformation__previewSupport" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getPreviewSupport(),
            "equipmentInformation__numberOfSofaSeat" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getNumberOfSofaSeat(),
            "equipmentInformation__commercialUse" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getCommercialUse(),
            "equipmentInformation__accompaniedByPet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAccompaniedByPet(),
            "equipmentInformation__staffResident" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getStaffResident(),
            "equipmentInformation__affiliatedRestaurant" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAffiliatedRestaurant(),
            "equipmentInformation__affiliatedParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getAffiliatedParkingLot(),
            "equipmentInformation__barrierFree" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBarrierFree(),
            "equipmentInformation__peripheralConvenienceStore" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getPeripheralConvenienceStore(),
            "equipmentInformation__distanceToConvenienceStore" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToConvenienceStore(),
            "equipmentInformation__surroundingSupermarket" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getSurroundingSupermarket(),
            "equipmentInformation__distanceToTheSupermarket" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getDistanceToTheSupermarket(),
            "equipmentInformation__beverageVendingMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getBeverageVendingMachine(),
            "equipmentInformation__tobaccoVendingMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getTobaccoVendingMachine(),
            "equipmentInformation__other" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentBasicInformation()->getOther(),

            "equipmentInformation__wifi" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getWifi(),
            "equipmentInformation__audioSpeaker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getAudioSpeaker(),
            "equipmentInformation__monitor" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getMonitor(),
            "equipmentInformation__toilet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getToilet(),
            "equipmentInformation__kitchen" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getKitchen(),
            "equipmentInformation__refrigerator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getRefrigerator(),
            "equipmentInformation__freezer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getFreezer(),
            "equipmentInformation__iceMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getIceMachine(),
            "equipmentInformation__airConditioner" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getAirConditioner(),
            "equipmentInformation__elevator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getElevator(),
            "equipmentInformation__tvSet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getTvSet(),
            "equipmentInformation__soundProofingEquipment" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getSoundProofingEquipment(),
            "equipmentInformation__karaoke" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getKaraoke(),
            "equipmentInformation__microphone" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getMicrophone(),
            "equipmentInformation__projector" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getProjector(),
            "equipmentInformation__DVDPlayer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentGeneralInformation()->getDVDPlayer(),

            "whiteboard" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getWhiteboard(),
            "copierOrMultifunctionMachine" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getCopierOrMultifunctionMachine(),
            "moderator" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentConferenceInformation()->getModerator(),

            "equipmentInformation__barCounter" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBarCounter(),
            "equipmentInformation__gardenOrLawn" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getGardenOrLawn(),
            "equipmentInformation__bathtub" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBathtub(),
            "equipmentInformation__spiralStaircase" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getSpiralStaircase(),
            "equipmentInformation__atrium" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getAtrium(),
            "equipmentInformation__hearth" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getHearth(),
            "equipmentInformation__japaneseStyleRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getJapaneseStyleRoom(),
            "equipmentInformation__balcony" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBalcony(),
            "equipmentInformation__veranda" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getVeranda(),
            "equipmentInformation__rooftop" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getRooftop(),
            "equipmentInformation__bullbackShooting" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBullbackShooting(),
            "equipmentInformation__R_Horizont" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getRHorizont(),
            "equipmentInformation__whiteHorizont" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getWhiteHorizont(),
            "equipmentInformation__birdEyeViewShooting" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getBirdEyeViewShooting(),
            "equipmentInformation__ancillaryServices" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getAncillaryServices(),
            "equipmentInformation__reflector" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getReflector(),
            "equipmentInformation__tripod" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getTripod(),
            "equipmentInformation__electricCapacity" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getElectricCapacity(),
            "equipmentInformation__electricCapacityType" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getElectricCapacityType(),
            "equipmentInformation__largeParkingLot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getLargeParkingLot(),
            "equipmentInformation__pool" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getPool(),
            "equipmentInformation__terrace" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getTerrace(),
            "equipmentInformation__lightingSpotlight" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getLightingSpotlight(),
            "equipmentInformation__waitingRoomOrMakeupRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShootingInformation()->getWaitingRoomOrMakeupRoom(),

            "equipmentInformation__rentalShoes" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getRentalShoes(),
            "equipmentInformation__yogaMat" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getYogaMat(),
            "equipmentInformation__wallMirrored" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getWallMirrored(),
            "equipmentInformation__DJ_Booth" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getDJBooth(),
            "equipmentInformation__drumSet" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getDrumSet(),
            "equipmentInformation__piano" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getPiano(),
            "equipmentInformation__showerRoom" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getShowerRoom(),
            "equipmentInformation__fullLengthMirror" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getFullLengthMirror(),
            "equipmentInformation__stage" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentEventInformation()->getStage(),

            "equipmentInformation__BBQ_Stove" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getBBQStove(),
            "equipmentInformation__wineCellar" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getWineCellar(),
            "equipmentInformation__toaster" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getToaster(),
            "equipmentInformation__coffeeMaker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getCoffeeMaker(),
            "equipmentInformation__riceCooker" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getRiceCooker(),
            "equipmentInformation__oven" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getOven(),
            "equipmentInformation__microwave" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getMicrowave(),
            "equipmentInformation__grilledFish" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getGrilledFish(),
            "equipmentInformation__fryingPan" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getFryingPan(),
            "equipmentInformation__pot" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPot(),
            "equipmentInformation__kitchenKnife" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getKitchenKnife(),
            "equipmentInformation__stove" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getStove(),
            "equipmentInformation__cutlery" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getCutlery(),
            "equipmentInformation__chopsticks" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getChopsticks(),
            "equipmentInformation__glass" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getGlass(),
            "equipmentInformation__plate" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPlate(),
            "equipmentInformation__partGame" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentPartyInformation()->getPartGame(),

            "equipmentInformation__waterServer" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShareInformation()->getWaterServer(),
            "equipmentInformation__treatmentTable" => $rentalSpace->getRentalSpaceEquipmentInformation()->getEquipmentShareInformation()->getTreatmentTable()
        ];

        ModelRentalSpaceEav::where('namespace', $rentalSpace->getRentalSpaceId()->getValue())
            ->where('type_step', RentalSpaceTypeDataEav::fromType(RentalSpaceTypeDataEav::EQUIPMENT_INFORMATION)->getValue())
            ->delete();

        foreach ($dataEav as $key => $value) {
            if ($value === null) {
                unset($dataEav[$key]);
            } else {
                ModelRentalSpaceEav::create([
                    'namespace' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'attribute' => $key,
                    'value' => $value,
                    'type_step' => RentalSpaceTypeDataEav::fromType(RentalSpaceTypeDataEav::EQUIPMENT_INFORMATION)->getValue()
                ]);
            }
        }

        return $rentalSpace->getRentalSpaceId();
    }
}
