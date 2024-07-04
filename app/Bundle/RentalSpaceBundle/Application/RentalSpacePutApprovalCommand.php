<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePutApprovalCommand
{
    public int $rentalSpaceId;
    public string $status;

    /**
     * @param int $rentalSpaceId
     * @param string $status
     */
    public function __construct(
        int $rentalSpaceId,
        string $status
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->status = $status;
    }
}
