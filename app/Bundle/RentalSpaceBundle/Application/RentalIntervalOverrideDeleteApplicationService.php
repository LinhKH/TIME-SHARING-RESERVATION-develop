<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalOverrideId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalIntervalOverrideDeleteApplicationService
{
    /**
     * Rental Space Interval Repository
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
     * @param RentalIntervalOverrideDeleteCommand $command
     * @return RentalIntervalOverrideDeleteResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalIntervalOverrideDeleteCommand $command): RentalIntervalOverrideDeleteResult
    {
        foreach ($command->rentalOverrides as $rentalOverride) {
            $this->rentalSpaceRentalIntervalRepository->deleteOverrideIntervalById(new RentalIntervalId($rentalOverride->rentalIntervalId), new RentalIntervalOverrideId($rentalOverride->rentalIntervalOverrideId));
        }
        return new RentalIntervalOverrideDeleteResult(true);
    }
}
