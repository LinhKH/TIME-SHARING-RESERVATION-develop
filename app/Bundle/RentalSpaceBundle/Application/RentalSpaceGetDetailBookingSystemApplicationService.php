<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailBookingSystemApplicationService
{
    /**
     * RentalSpaceBookingSystemRepository
     *
     * @var IRentalSpaceBookingSystemRepository
     */
    private IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository
    )
    {
        $this->rentalSpaceBookingSystemRepository = $rentalSpaceBookingSystemRepository;
    }

    /**
     * @param RentalSpaceGetDetailBookingSystemCommand $command
     * @return RentalSpaceGetDetailBookingSystemResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailBookingSystemCommand $command): RentalSpaceGetDetailBookingSystemResult
    {
        $bookingSystems = $this->rentalSpaceBookingSystemRepository->findById(new RentalSpaceId($command->rentalSpaceId));

        if (!$bookingSystems) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        [$resultBookingSystem, $termsOfUse] = $bookingSystems;

        return new RentalSpaceGetDetailBookingSystemResult(
            $resultBookingSystem->getAgreeingToTerms()->getType(),
            $termsOfUse
        );
    }
}
