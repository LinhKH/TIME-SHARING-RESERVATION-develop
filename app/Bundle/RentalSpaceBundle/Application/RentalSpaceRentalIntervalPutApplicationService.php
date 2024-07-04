<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanStatusType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalInterval;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceRentalIntervalPutApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository
    )
    {
        $this->rentalSpaceRentalIntervalRepository = $rentalSpaceRentalIntervalRepository;
    }

    /**
     * @param RentalSpaceRentalIntervalPutCommand $command
     * @return RentalSpaceRentalIntervalPutResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceRentalIntervalPutCommand $command): RentalSpaceRentalIntervalPutResult
    {
        $rentalIntervalIds = null;
        foreach ($command->rentalIntervalIds as $key => $rentalIntervalId) {
            $findById = $this->rentalSpaceRentalIntervalRepository->findIntervalById(new RentalIntervalId($rentalIntervalId));
            if (!empty($findById)) {
                $rentalIntervalIds[] = new RentalIntervalId($rentalIntervalId);
            }
        }
        $holidayApplicabilityType = 1;
        if (!empty($command->holidayApplicabilityType)) {
            $holidayApplicabilityType = $command->holidayApplicabilityType;
        }
        if (!empty($command->status)) {
            $status = RentalPlanStatusType::fromValue($command->status)->getValue();
        } else {
            $status = null;
        }
        $rentalSpaceRentalInterval = new RentalSpaceRentalInterval(
            null,
            $rentalIntervalIds,
            $status,
            $command->applicabilityPeriods,
            RentalSpaceRentalIntervalHolidayApplicabilityType::fromType($holidayApplicabilityType),
            null,
            null,
            $command->tenancyPrice,
            $command->perPersonPrice,
            $command->maxSimultaneousReservations,
            $command->maxSimultaneousPeople,
        );

        $rentalSpace = new RentalSpace(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpaceRentalInterval,
            null,
            null,
            null
        );

        DB::beginTransaction();
        try {
            $rentalIntervalIds = $this->rentalSpaceRentalIntervalRepository->updateRentalInterval($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        $results = [];
        foreach ($rentalIntervalIds as $intervalId) {
            $results[] = $intervalId->getValue();
        }
        return new RentalSpaceRentalIntervalPutResult($results);
    }
}
