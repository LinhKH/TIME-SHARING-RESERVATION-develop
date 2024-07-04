<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetApplicationService
{
    /**
     * Rental Space Interval Repository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;

    /**
     * Rental Space General Repository
     *
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    )
    {
        $this->rentalSpaceRentalIntervalRepository = $rentalSpaceRentalIntervalRepository;
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
    }

    /**
     * @param RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetCommand $command
     * @return RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetCommand $command): RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetResult
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        if (!$rentalSpace) {
            return new RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetResult([]);
        }
        $rentalSlotUnavailableCacheEntryRepos = $this->rentalSpaceRentalIntervalRepository->findAllSlotUnavailableCacheEntryOfPlanInThisDay(new RentalSpaceId($command->rentalSpaceId), $command->month, $command->year);
        $rentalSlotUnavailableCacheEntries = [];

        foreach ($rentalSlotUnavailableCacheEntryRepos as $rentalSlotUnavailableCacheEntryRepo) {
            $rentalSlotsUnavailable = [];
            foreach ($rentalSlotUnavailableCacheEntryRepo->getIntervals() as $slotUnavailable) {
                $rentalSlotsUnavailable[] = new RentalSpaceRentalSlotIntervalCacheEntryResult(
                    $slotUnavailable->getRentalIntervalId()->getValue(),
                    $slotUnavailable->getRentalSpaceId()->getValue(),
                    null,
                    $slotUnavailable->getDayIndent()->format(DateTimeConst::FORMAT_YMD),
                    null,
                    null,
                    $slotUnavailable->getTenancyPrice(),
                    $slotUnavailable->getPerPersonPrice(),
                    $slotUnavailable->getAvailableSeatsCount(),
                    $slotUnavailable->getMostGenerousReservationWindowCloseTime()->format(DateTimeConst::FORMAT),
                    $slotUnavailable->getRentalSlotCacheEntryId()->getValue(),
                    $slotUnavailable->getStatus()->getValue()
                );
            }
            $rentalSlotUnavailableCacheEntries[] = new RentalSpaceRentalSlotIntervalCacheEntryInThisDayResult(
                $rentalSlotUnavailableCacheEntryRepo->getDate()->format(DateTimeConst::FORMAT_YMD),
                $rentalSlotsUnavailable
            );
        }
        return new RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetResult($rentalSlotUnavailableCacheEntries);
    }
}
