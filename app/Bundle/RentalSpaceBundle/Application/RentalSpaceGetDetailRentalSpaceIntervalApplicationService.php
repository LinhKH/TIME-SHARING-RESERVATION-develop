<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;

final class RentalSpaceGetDetailRentalSpaceIntervalApplicationService
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
     * @param RentalSpaceGetDetailRentalSpaceIntervalCommand $command
     * @return RentalSpaceGetDetailRentalSpaceIntervalResult[]|null
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailRentalSpaceIntervalCommand $command): ?array
    {
        $intervals = $this->rentalSpaceRentalIntervalRepository->findBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (!$intervals) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $response = [];
        foreach ($intervals as $interval) {
            $rentalIntervals = [];
            foreach ($interval['rentalIntervals'] as $intervalInformation) {
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
            $response[] = new RentalSpaceGetDetailRentalSpaceIntervalResult(
                $interval['rentalPlanId'],
                $interval['rentalPlanName'],
                $interval['planGroup'],
                $rentalIntervals,
            );
        }
        return $response;
    }
}
