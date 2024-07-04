<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceBookingSystem
{
    private RentalSpaceId $rentalSpaceId;
    private RentalSpaceAgreeingToTermsValue $agreeingToTerms;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceAgreeingToTermsValue $agreeingToTerms
     */

    public function __construct(
        RentalSpaceId $rentalSpaceId,
        RentalSpaceAgreeingToTermsValue $agreeingToTerms
    ) {
        $this->agreeingToTerms = $agreeingToTerms;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalSpaceAgreeingToTermsValue
     */
    public function getAgreeingToTerms(): RentalSpaceAgreeingToTermsValue
    {
        return $this->agreeingToTerms;
    }
}
