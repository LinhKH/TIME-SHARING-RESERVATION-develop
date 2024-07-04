<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceApproval
{
    private RentalSpaceId $rentalSpaceId;
    private string $status;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param string $status
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        string $status
    ){
        $this->status = $status;
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

}
