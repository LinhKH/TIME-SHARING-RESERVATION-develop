<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalSlotOverride as RentalIntervalSlotOverrideDomain;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanRentalSlotsIntervalOverride;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalIntervalSlotOverrideUpdatePutApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;

    /**
     * RentalSpacePlan Repository
     *
     * @var IRentalSpaceRentalPlanRepository
     */
    private IRentalSpaceRentalPlanRepository $rentalPlanRepository;

    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository,
        IRentalSpaceRentalPlanRepository $rentalPlanRepository
    )
    {
        $this->rentalSpaceRentalIntervalRepository = $rentalSpaceRentalIntervalRepository;
        $this->rentalPlanRepository = $rentalPlanRepository;
    }

    /**
     * @param RentalSpaceRentalIntervalPutCommand $command
     * @return RentalSpaceRentalIntervalPutResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle(RentalIntervalSlotOverrideUpdatePutCommand $command): RentalIntervalSlotOverrideUpdatePutResult
    {
        $plan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->spaceId), new RentalPlanId($command->planId));
        if (empty($plan)) {
            return new RentalIntervalSlotOverrideUpdatePutResult(null);
        }

        $rentalIntervals = [];
        foreach ($command->rentalIntervals as $rentalInterval) {
            $findById = $this->rentalSpaceRentalIntervalRepository->findIntervalById(new RentalIntervalId($rentalInterval->rentalIntervalId));
            if (!empty($findById)) {
                $rentalIntervals[] = new RentalIntervalSlotOverrideDomain(
                    null,
                    new RentalIntervalId($rentalInterval->rentalIntervalId),
                    new DateTime($rentalInterval->dayIndent),
                    new DateTime($rentalInterval->intervalStartTime),
                    new DateTime($rentalInterval->intervalEndTime),
                    null
                );
            }
        }
        $rentalIntervalSlotsInterval = new RentalPlanRentalSlotsIntervalOverride(
            new RentalPlanId($command->planId),
            $rentalIntervals,
            $command->note,
            $command->tenancyPrice,
            $command->perPersonPrice
        );

        DB::beginTransaction();
        try {
            $rentalIntervalSlotsOverride = $this->rentalSpaceRentalIntervalRepository->createOrUpdateRentalIntervalSlotsOverride($rentalIntervalSlotsInterval);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        return new RentalIntervalSlotOverrideUpdatePutResult($rentalIntervalSlotsOverride->getValue());
    }
}
