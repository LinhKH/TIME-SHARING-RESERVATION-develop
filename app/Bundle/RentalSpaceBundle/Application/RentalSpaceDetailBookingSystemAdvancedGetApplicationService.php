<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\LastMinuteDiscountType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceBookingSystemAdvanced;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceDetailBookingSystemAdvancedGetApplicationService
{
    /**
     * RentalSpaceBookingSystemRepository
     *
     * @var IRentalSpaceBookingSystemRepository
     */
    private IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository;
    private IRentalSpaceGeneralRepository $generalRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository,
        IRentalSpaceGeneralRepository $generalRepository
    )
    {
        $this->generalRepository = $generalRepository;
        $this->rentalSpaceBookingSystemRepository = $rentalSpaceBookingSystemRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceDetailBookingSystemAdvancedGetCommand $command): RentalSpaceDetailBookingSystemAdvancedGetResult
    {
        $rentalSpace = $this->generalRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $bookingSystemAdvanced = $this->rentalSpaceBookingSystemRepository->findBookingSystemAdvancesBySpaceId(new RentalSpaceId($command->rentalSpaceId));
        return new RentalSpaceDetailBookingSystemAdvancedGetResult(
            $bookingSystemAdvanced->getRentalSpaceId()->getValue(),
            $bookingSystemAdvanced->getEnableLastMinuteDiscount(),
            $bookingSystemAdvanced->getLastMinuteBookDiscountDaysBeforeCount(),
            $bookingSystemAdvanced->getLastMinuteBookDiscountPercentage()
        );
    }
}
