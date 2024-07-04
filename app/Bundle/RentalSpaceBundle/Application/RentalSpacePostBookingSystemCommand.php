<?php

namespace App\Bundle\RentalSpaceBundle\Application;

class RentalSpacePostBookingSystemCommand
{
    public int $rentalSpaceId;
    public int $agreeingToTerms;

    /**
     * @param int $rentalSpaceId
     * @param int $agreeingToTerms
     */
    public function __construct(
        int $rentalSpaceId,
        int $agreeingToTerms
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->agreeingToTerms = $agreeingToTerms;
    }
}
