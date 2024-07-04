<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalOverrideDeleteCommand
{
    public array $rentalOverrides;

    /**
     * @param RentalIntervalOverrideDelete[] $rentalOverrides
     */
    public function __construct(
        array $rentalOverrides
    ){
        $this->rentalOverrides = $rentalOverrides;
    }
}
