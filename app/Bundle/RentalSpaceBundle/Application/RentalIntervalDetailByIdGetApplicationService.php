<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;

final class RentalIntervalDetailByIdGetApplicationService
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
     * @param RentalIntervalDetailByIdGetCommand $command
     * @return RentalIntervalDetailByIdGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalIntervalDetailByIdGetCommand $command): RentalIntervalDetailByIdGetResult
    {
        $rentalIntervalRepos = $this->rentalSpaceRentalIntervalRepository->findIntervalById(new RentalIntervalId($command->rentalIntervalId));

        if (empty($rentalIntervalRepos)) {
            return new RentalIntervalDetailByIdGetResult(null);
        }

        return new RentalIntervalDetailByIdGetResult(
            new RentalSpaceRentalIntervalResult(
                $rentalIntervalRepos->getId(),
                $rentalIntervalRepos->getApplicabilityPeriods(),
                $rentalIntervalRepos->getEndTimeFormatted(),
                $rentalIntervalRepos->getStartTimeFormatted(),
                RentalSpaceRentalIntervalHolidayApplicabilityType::fromValue($rentalIntervalRepos->getHolidayApplicabilityType())->getType(),
                $rentalIntervalRepos->getStatus(),
                $rentalIntervalRepos->getTenancyPrice(),
                $rentalIntervalRepos->getTenancyPriceWithFraction(),
                $rentalIntervalRepos->getPerPersonPrice(),
                $rentalIntervalRepos->getPerPersonPriceWithFraction(),
                $rentalIntervalRepos->getMaxSimultaneousReservations(),
                $rentalIntervalRepos->getMaxSimultaneousPeople()
            )
        );
    }
}
