<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceAgreeingToTermsValue;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceBookingSystem;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

final class RentalSpacePostBookingSystemApplicationService
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
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function handle(RentalSpacePostBookingSystemCommand $command): RentalSpacePostBookingSystemResult
    {
        $rentalSpaceBookingSystem = new RentalSpaceBookingSystem(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceAgreeingToTermsValue::fromType($command->agreeingToTerms),

        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::BOOKING_SYSTEM),
            null,
            null,
            null,
            $rentalSpaceBookingSystem,
            null,
            null,
            null,
            null,
            null,
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceBookingSystemRepository->createRentalSpaceBookingSystem($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePostBookingSystemResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
