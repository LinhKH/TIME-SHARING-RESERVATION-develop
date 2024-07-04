<?php

namespace App\Bundle\TransportationBundle\Application;

use App\Bundle\TransportationBundle\Domain\ITransportationRepository;

final class TransportationSuggestGetApplicationService
{
    private ITransportationRepository $transportationRepository;

    /**
     * @param ITransportationRepository $transportationRepository
     */
    public function __construct(
        ITransportationRepository $transportationRepository
    ) {
        $this->transportationRepository = $transportationRepository;
    }

    /**
     * @param TransportationSuggestGetCommand $command command
     * @return TransportationSuggestGetResult[]
     */
    public function handle(TransportationSuggestGetCommand $command): array
    {
        $transportationQueries = $this->transportationRepository->findByNameTransportation($command->nameTransportation);
        $transportations = [];

        foreach ($transportationQueries as $information) {
            $transportations[] = new TransportationSuggestGetResult(
                $information->getTransportationId()->getValue(),
                $information->getTransportationName(),
                $information->getRef(),
                $information->getRoute()
            );
        }
        return $transportations;
    }
}
