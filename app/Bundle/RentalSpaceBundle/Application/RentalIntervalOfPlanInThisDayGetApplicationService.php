<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;

final class RentalIntervalOfPlanInThisDayGetApplicationService
{

    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;

    /**
     * RentalSpaceGeneralRepository
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
     * @param RentalIntervalOfPlanInThisDayGetCommand $command
     * @return RentalIntervalOfPlanInThisDayGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalIntervalOfPlanInThisDayGetCommand $command): RentalIntervalOfPlanInThisDayGetResult
    {
        $rentalPlan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), new RentalPlanId($command->rentalPlanId));
        if (!$rentalPlan) {
            return new RentalIntervalOfPlanInThisDayGetResult([]);
        }
        $rentalIntervalRepos = $this->rentalSpaceRentalIntervalRepository->findAllIntervalOfPlanInThisDay(new RentalPlanId($command->rentalPlanId), $command->month, $command->year);
        $rentalIntervals = [];
        foreach ($rentalIntervalRepos as $rentalIntervalRepo) {
            $intervalOfDay = [];
            foreach ($rentalIntervalRepo->getIntervals() as $interval) {
                $intervalOfDay[] = new RentalSpaceRentalIntervalResult(
                    $interval->getId(),
                    $interval->getApplicabilityPeriods(),
                    $interval->getEndTimeFormatted(),
                    $interval->getStartTimeFormatted(),
                    RentalSpaceRentalIntervalHolidayApplicabilityType::fromValue($interval->getHolidayApplicabilityType())->getType(),
                    $interval->getStatus(),
                    $interval->getTenancyPrice(),
                    $interval->getTenancyPriceWithFraction(),
                    $interval->getPerPersonPrice(),
                    $interval->getPerPersonPriceWithFraction(),
                    $interval->getMaxSimultaneousReservations(),
                    $interval->getMaxSimultaneousPeople()
                );
            }
            $rentalIntervals[] = new RentalSpaceRentalIntervalInThisDayResult(
                $rentalIntervalRepo->getDate()->format(DateTimeConst::FORMAT_YMD),
                $intervalOfDay
            );
        }
        return new RentalIntervalOfPlanInThisDayGetResult($rentalIntervals);
    }
}
