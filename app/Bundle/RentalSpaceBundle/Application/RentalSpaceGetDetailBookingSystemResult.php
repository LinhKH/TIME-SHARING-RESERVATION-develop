<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailBookingSystemResult
{
    public int $agreeingToTerms;
    public string $spaceTermsOfUse;

    /**
     * @param int $agreeingToTerms
     * @param string $spaceTermsOfUse
     */
    public function __construct(
        int $agreeingToTerms,
        string $spaceTermsOfUse
    ){
        $this->spaceTermsOfUse = $spaceTermsOfUse;
        $this->agreeingToTerms = $agreeingToTerms;
    }
}
