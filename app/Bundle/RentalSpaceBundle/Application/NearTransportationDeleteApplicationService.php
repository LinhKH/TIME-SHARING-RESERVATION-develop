<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceNearTransportationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TransportationBundle\Domain\TransportationId;

final class NearTransportationDeleteApplicationService
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
     * @param NearTransportationDeleteCommand $command
     * @return NearTransportationDeleteResult
     * @throws InvalidArgumentException
     */
    public function handle(NearTransportationDeleteCommand $command): NearTransportationDeleteResult
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        $resultNearTransportations = [];
        if (empty($rentalSpace)) {
            return new NearTransportationDeleteResult($command->rentalSpaceId);
        }
        $deleteNearTransportation = $this->nearTransportationRepository->deleteNearTransportation(
            new RentalSpaceId($command->rentalSpaceId),
            new TransportationId($command->nearTransportationId)
        );


        return new NearTransportationDeleteResult(
            $deleteNearTransportation->getValue()
        );
    }
}
