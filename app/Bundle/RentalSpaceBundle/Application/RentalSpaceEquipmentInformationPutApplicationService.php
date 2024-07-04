<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
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
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceEquipmentInformationPutApplicationService
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
     * Handle Post Equipment Information
     *
     * @param RentalSpaceEquipmentInformationPutCommand $command
     * @return RentalSpaceEquipmentInformationPutResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceEquipmentInformationPutCommand $command): RentalSpaceEquipmentInformationPutResult
    {
        $equipmentBasicInformation = new RentalSpaceEquipmentBasicInformation(
            $command->basicInformationCommand->bringingInFoodAndDrink,
            $command->basicInformationCommand->smoking,
            $command->basicInformationCommand->parking,
            $command->basicInformationCommand->numberOfParkingLot,
            $command->basicInformationCommand->neighborhoodPayParking,
            $command->basicInformationCommand->distanceToPaidParking,
            $command->basicInformationCommand->flowToUse,
            $command->basicInformationCommand->luggageStorageSupport,
            $command->basicInformationCommand->takkyubinReceiptCorrespondence,
            $command->basicInformationCommand->numberOfTable,
            $command->basicInformationCommand->numberOfChairs,
            $command->basicInformationCommand->numberOfSofaSeat,
            $command->basicInformationCommand->previewSupport,
            $command->basicInformationCommand->commercialUse,
            $command->basicInformationCommand->accompaniedByPet,
            $command->basicInformationCommand->staffResident,
            $command->basicInformationCommand->affiliatedRestaurant,
            $command->basicInformationCommand->affiliatedParkingLot,
            $command->basicInformationCommand->barrierFree,
            $command->basicInformationCommand->peripheralConvenienceStore,
            $command->basicInformationCommand->distanceToConvenienceStore,
            $command->basicInformationCommand->surroundingSupermarket,
            $command->basicInformationCommand->distanceToTheSupermarket,
            $command->basicInformationCommand->beverageVendingMachine,
            $command->basicInformationCommand->tobaccoVendingMachine,
            $command->basicInformationCommand->other
        );
        $equipmentGeneralInformation = new RentalSpaceEquipmentGeneralInformation(
            $command->generalInformationCommand->wifi,
            $command->generalInformationCommand->audioSpeaker,
            $command->generalInformationCommand->monitor,
            $command->generalInformationCommand->toilet,
            $command->generalInformationCommand->kitchen,
            $command->generalInformationCommand->refrigerator,
            $command->generalInformationCommand->freezer,
            $command->generalInformationCommand->iceMachine,
            $command->generalInformationCommand->airConditioner,
            $command->generalInformationCommand->elevator,
            $command->generalInformationCommand->tvSet,
            $command->generalInformationCommand->soundProofingEquipment,
            $command->generalInformationCommand->karaoke,
            $command->generalInformationCommand->microphone,
            $command->generalInformationCommand->dvdPlayer,
            $command->generalInformationCommand->projector
        );
        $equipmentConferenceInformation = new RentalSpaceEquipmentConferenceInformation(
            $command->conferenceInformationCommand->whiteboard,
            $command->conferenceInformationCommand->copierOrMultifunctionMachine,
            $command->conferenceInformationCommand->moderator
        );
        $equipmentShootingInformation = new RentalSpaceEquipmentShootingInformation(
            $command->shootingInformationCommand->waitingRoomOrMakeupRoom,
            $command->shootingInformationCommand->lightingSpotlight,
            $command->shootingInformationCommand->terrace,
            $command->shootingInformationCommand->pool,
            $command->shootingInformationCommand->electricCapacityType,
            $command->shootingInformationCommand->electricCapacity,
            $command->shootingInformationCommand->largeParkingLot,
            $command->shootingInformationCommand->tripod,
            $command->shootingInformationCommand->reflector,
            $command->shootingInformationCommand->ancillaryServices,
            $command->shootingInformationCommand->birdEyeViewShooting,
            $command->shootingInformationCommand->whiteHorizont,
            $command->shootingInformationCommand->rHorizont,
            $command->shootingInformationCommand->bullbackShooting,
            $command->shootingInformationCommand->rooftop,
            $command->shootingInformationCommand->veranda,
            $command->shootingInformationCommand->balcony,
            $command->shootingInformationCommand->japaneseStyleRoom,
            $command->shootingInformationCommand->hearth,
            $command->shootingInformationCommand->atrium,
            $command->shootingInformationCommand->spiralStaircase,
            $command->shootingInformationCommand->bathtub,
            $command->shootingInformationCommand->gardenOrLawn,
            $command->shootingInformationCommand->barCounter
        );
        $equipmentEventInformation = new RentalSpaceEquipmentEventInformation(
            $command->eventInformationCommand->stage,
            $command->eventInformationCommand->fullLengthMirror,
            $command->eventInformationCommand->showerRoom,
            $command->eventInformationCommand->piano,
            $command->eventInformationCommand->drumSet,
            $command->eventInformationCommand->DJ_Booth,
            $command->eventInformationCommand->wallMirrored,
            $command->eventInformationCommand->yogaMat,
            $command->eventInformationCommand->rentalShoes
        );
        $equipmentPartyInformation = new RentalSpaceEquipmentPartyInformation(
            $command->partyInformationCommand->partGame,
            $command->partyInformationCommand->plate,
            $command->partyInformationCommand->glass,
            $command->partyInformationCommand->chopsticks,
            $command->partyInformationCommand->cutlery,
            $command->partyInformationCommand->stove,
            $command->partyInformationCommand->kitchenKnife,
            $command->partyInformationCommand->pot,
            $command->partyInformationCommand->fryingPan,
            $command->partyInformationCommand->grilledFish,
            $command->partyInformationCommand->microwave,
            $command->partyInformationCommand->oven,
            $command->partyInformationCommand->riceCooker,
            $command->partyInformationCommand->coffeeMaker,
            $command->partyInformationCommand->toaster,
            $command->partyInformationCommand->wineCellar,
            $command->partyInformationCommand->bbqStove
        );
        $equipmentShareInformation = new RentalSpaceEquipmentShareInformation(
            $command->shareInformationCommand->treatmentTable,
            $command->shareInformationCommand->waterServer
        );

        $equipmentInformation = new RentalSpaceEquipmentInformation(
            new RentalSpaceId($command->rentalSpaceId),
            $equipmentBasicInformation,
            $equipmentGeneralInformation,
            $equipmentConferenceInformation,
            $equipmentShootingInformation,
            $equipmentEventInformation,
            $equipmentPartyInformation,
            $equipmentShareInformation
        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::EQUIPMENT_INFORMATION),
            null,
            null,
            $equipmentInformation,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        DB::beginTransaction();
        try {
            $rentalSpaceId = $this->rentalSpaceEquipmentInformationRepository->updateRentalSpaceEquipmentInformation($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした。');
        }

        return new RentalSpaceEquipmentInformationPutResult(
            $rentalSpaceId->getValue()
        );
    }
}
