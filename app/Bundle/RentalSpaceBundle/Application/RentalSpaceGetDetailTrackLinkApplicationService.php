<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceTrackLinkRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailTrackLinkApplicationService
{
    /**
     * Rental Space Track Link Repository
     *
     * @var IRentalSpaceTrackLinkRepository
     */
    private IRentalSpaceTrackLinkRepository $rentalSpaceTrackLinkRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceTrackLinkRepository $rentalSpaceTrackLinkRepository
    )
    {
        $this->rentalSpaceTrackLinkRepository = $rentalSpaceTrackLinkRepository;
    }

    /**
     * Detail Tracking Link
     * @param RentalSpaceGetDetailTrackLinkCommand $command
     *
     * @return RentalSpaceGetDetailTrackLinkResult[]|null
     *
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceGetDetailTrackLinkCommand $command): ?array
    {
        $trackingLinks = $this->rentalSpaceTrackLinkRepository->findBySpaceId(new RentalSpaceId($command->rentalSpaceId));
        $response = [];
        if (!empty($trackingLinks)) {
            foreach ($trackingLinks as $trackingLink) {
                $response[] = new RentalSpaceGetDetailTrackLinkResult(
                    $trackingLink->getTrackingLinkId()->getValue(),
                    $trackingLink->getRentalSpaceId()->getValue(),
                    $trackingLink->getTrackingLinkName(),
                    $trackingLink->getTrackingLinkToSpaceTopPage(),
                    $trackingLink->getTrackingLinkToSpaceReservationPage()
                );
            }
        }
        return $response;
    }
}
