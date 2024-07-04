<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalOverrideInterval;

final class RentalIntervalOverrideOfPlanInThisDayGetApplicationService
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
     * @param RentalIntervalOverrideOfPlanInThisDayGetCommand $command
     * @return RentalIntervalOverrideOfPlanInThisDayGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalIntervalOverrideOfPlanInThisDayGetCommand $command): RentalIntervalOverrideOfPlanInThisDayGetResult
    {
        $rentalPlan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), new RentalPlanId($command->rentalPlanId));
        if (!$rentalPlan) {
            return new RentalIntervalOverrideOfPlanInThisDayGetResult([]);
        }
        $rentalOverrideIntervalRepos = $this->rentalSpaceRentalIntervalRepository->findAllOverrideIntervalOfPlanInThisDay(new RentalPlanId($command->rentalPlanId), $command->month, $command->year);
        $rentalOverrideIntervals = [];

        foreach ($rentalOverrideIntervalRepos as $rentalOverrideIntervalRepo) {
            $intervalOfDay = [];
            foreach ($rentalOverrideIntervalRepo->getIntervals() as $interval) {
                $intervalOfDay[] = new RentalIntervalOverrideResult(
                    $interval->getRentalIntervalOverrideId()->getValue(),
                    $interval->getRentalIntervalId()->getValue(),
                    $interval->getDayIndent()->format(DateTimeConst::FORMAT_YMD),
                    $interval->getIntervalStartTime()->format(DateTimeConst::FORMAT_HI),
                    $interval->getIntervalEndTime()->format(DateTimeConst::FORMAT_HI),
                    $interval->getTenancyPrice()
                );
            }
            $rentalOverrideIntervals[] = new RentalSpaceRentalIntervalInThisDayResult(
                $rentalOverrideIntervalRepo->getDate()->format(DateTimeConst::FORMAT_YMD),
                $intervalOfDay
            );
        }
        return new RentalIntervalOverrideOfPlanInThisDayGetResult($rentalOverrideIntervals);
    }
}
