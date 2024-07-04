<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailApprovalResult
{
    public RentalSpaceId $rentalSpaceId;
    public string $status;

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
}
