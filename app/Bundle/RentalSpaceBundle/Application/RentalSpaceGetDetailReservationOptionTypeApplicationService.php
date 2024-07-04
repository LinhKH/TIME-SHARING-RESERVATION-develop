<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceReservationOptionTypeRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailReservationOptionTypeApplicationService
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
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailReservationOptionTypeCommand $command): RentalSpaceGetDetailReservationOptionTypeResult
    {
        $reservationOptionTypes = $this->rentalSpaceReservationOptionTypeRepository->findById(new RentalSpaceId($command->rentalSpaceId));

        if (!$reservationOptionTypes) {
            return new RentalSpaceGetDetailReservationOptionTypeResult([]);
        }

        return new RentalSpaceGetDetailReservationOptionTypeResult($reservationOptionTypes);
    }
}
