<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;

final class RentalSpaceRentalIntervalDetailByPlanIdGetApplicationService
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
     * @param RentalSpaceRentalIntervalDetailByPlanIdGetCommand $command
     * @return RentalSpaceRentalIntervalDetailByPlanIdGetResult
     * @throws InvalidArgumentException|RecordNotFoundException
     */
    public function handle(RentalSpaceRentalIntervalDetailByPlanIdGetCommand $command): RentalSpaceRentalIntervalDetailByPlanIdGetResult
    {
        $rentalPlan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), new RentalPlanId($command->rentalPlanId));
        if (!$rentalPlan) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $rentalIntervalRepos = $this->rentalSpaceRentalIntervalRepository->findAllIntervalByPlanId(new RentalPlanId($command->rentalPlanId));
        $rentalIntervals = [];
        foreach ($rentalIntervalRepos as $intervalInformation) {
            $rentalIntervals[] = new RentalSpaceRentalIntervalResult(
                $intervalInformation->getId(),
                $intervalInformation->getApplicabilityPeriods(),
                $intervalInformation->getEndTimeFormatted(),
                $intervalInformation->getStartTimeFormatted(),
                RentalSpaceRentalIntervalHolidayApplicabilityType::fromValue($intervalInformation->getHolidayApplicabilityType())->getType(),
                $intervalInformation->getStatus(),
                $intervalInformation->getTenancyPrice(),
                $intervalInformation->getTenancyPriceWithFraction(),
                $intervalInformation->getPerPersonPrice(),
                $intervalInformation->getPerPersonPriceWithFraction(),
                $intervalInformation->getMaxSimultaneousReservations(),
                $intervalInformation->getMaxSimultaneousPeople()
            );
        }
        return new RentalSpaceRentalIntervalDetailByPlanIdGetResult($rentalIntervals);
    }
}
