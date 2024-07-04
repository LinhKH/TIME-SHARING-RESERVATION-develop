<?php

namespace App\Bundle\TransportationBundle\Domain;

interface ITransportationRepository
{

    /**
     * Suggest Transportation
     * @param string $nameTransportation
     * @return TransportationSuggestInformation[]
     */
    public function findByNameTransportation(string $nameTransportation): array;
}
