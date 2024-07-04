<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceNearTransportationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class NearTransportationGetApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceNearTransportationRepository
     */
    private IRentalSpaceNearTransportationRepository $nearTransportationRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceNearTransportationRepository $nearTransportationRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    )
    {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->nearTransportationRepository = $nearTransportationRepository;
    }

    /**
     * @param NearTransportationGetCommand $command
     * @return NearTransportationGetResult[]
     * @throws InvalidArgumentException
     */
    public function handle(NearTransportationGetCommand $command): array
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        $resultNearTransportations = [];
        if (empty($rentalSpace)) {
            return $resultNearTransportations;
        }
        $getNearTransportationList = $this->nearTransportationRepository->findAllTransportationBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        foreach ($getNearTransportationList as $information) {
            $resultNearTransportations[] = new NearTransportationGetResult(
                $information->getTransportationStationId()->getValue(),
                $information->getTransportationName(),
                $information->getRef(),
                $information->getWalkingDuration(),
                $information->getRoute(),
                $information->getNearTransportationId()
            );
        }
        return $resultNearTransportations;
    }
}
