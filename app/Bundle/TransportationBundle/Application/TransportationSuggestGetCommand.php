<?php

namespace App\Bundle\TransportationBundle\Application;

class TransportationSuggestGetCommand
{
    public string $nameTransportation;

    /**
     * @param string $nameTransportation
     */
    public function __construct(
        string $nameTransportation
    ){
        $this->nameTransportation = $nameTransportation;
    }
}
