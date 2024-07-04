<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetApplicationService
{
    /**
     * Rental Space Interval Repository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;

    /**
     * Rental Space Plan Repository
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
     * @param RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetCommand $command
     * @return RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetCommand $command): RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetResult
    {
        $rentalPlan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), new RentalPlanId($command->rentalPlanId));
        if (!$rentalPlan) {
            return new RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetResult([]);
        }
        $rentalSlotCacheEntryRepos = $this->rentalSpaceRentalIntervalRepository->findAllSlotCacheEntryOfPlanInThisDay(new RentalPlanId($command->rentalPlanId), $command->month, $command->year);
        $rentalSlotCacheEntries = [];

        foreach ($rentalSlotCacheEntryRepos as $rentalSlotCacheEntryRepo) {
            $rentalSlots = [];
            foreach ($rentalSlotCacheEntryRepo->getIntervals() as $slot) {
                $rentalSlots[] = new RentalSpaceRentalSlotIntervalCacheEntryResult(
                    $slot->getRentalIntervalId()->getValue(),
                    $slot->getRentalSpaceId()->getValue(),
                    $slot->getRentalPlanId()->getValue(),
                    $slot->getDayIndent()->format(DateTimeConst::FORMAT_YMD),
                    $slot->getIntervalStartTime()->format(DateTimeConst::FORMAT_HI),
                    $slot->getIntervalEndTime()->format(DateTimeConst::FORMAT_HI),
                    $slot->getTenancyPrice(),
                    $slot->getPerPersonPrice(),
                    $slot->getAvailableSeatsCount(),
                    $slot->getMostGenerousReservationWindowCloseTime()->format(DateTimeConst::FORMAT),
                    $slot->getRentalSlotCacheEntryId()->getValue(),
                    $slot->getStatus()
                );
            }
            $rentalSlotCacheEntries[] = new RentalSpaceRentalSlotIntervalCacheEntryInThisDayResult(
                $rentalSlotCacheEntryRepo->getDate()->format(DateTimeConst::FORMAT_YMD),
                $rentalSlots
            );
        }
        return new RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetResult($rentalSlotCacheEntries);
    }
}
