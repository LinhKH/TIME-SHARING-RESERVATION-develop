<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceReservationOptionTypeRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceReservationOptionTypeObject;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceReservationOptionTypes;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostReservationOptionTypeApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceReservationOptionTypeRepository
     */
    private IRentalSpaceReservationOptionTypeRepository $rentalSpaceReservationOptionTypeRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceReservationOptionTypeRepository $rentalSpaceReservationOptionTypeRepository
    )
    {
        $this->rentalSpaceReservationOptionTypeRepository = $rentalSpaceReservationOptionTypeRepository;
    }

    /**
     * Rental Space Reservation Option Type
     *
     * @param RentalSpacePostReservationOptionTypeCommand $command
     * @return RentalSpacePostReservationOptionTypeResult
     * @throws TransactionException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function handle(RentalSpacePostReservationOptionTypeCommand $command): RentalSpacePostReservationOptionTypeResult
    {
        $rentalSpaceReservationOptionTypeObjects = [];
        foreach ($command->reservationOptionTypes as $reservationOptionType) {
            $rentalSpaceReservationOptionTypeObjects[] = new RentalSpaceReservationOptionTypeObject(
                $reservationOptionType->titleJa,
                $reservationOptionType->descriptionJa,
                $reservationOptionType->price,
                $reservationOptionType->priceWithFraction,
                $reservationOptionType->unitType,
                $reservationOptionType->active,
                $reservationOptionType->orderNumber
            );
        }

        $rentalSpaceReservationOptionTypes = new RentalSpaceReservationOptionTypes(
            new RentalSpaceId($command->rentalSpaceId),
            $rentalSpaceReservationOptionTypeObjects
        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::RESERVATION_OPTION),
            null,
            null,
            null,
            null,
            $rentalSpaceReservationOptionTypes,
            null,
            null,
            null,
            null,
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceReservationOptionTypeRepository->createRentalSpaceReservationOptionType($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePostReservationOptionTypeResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
