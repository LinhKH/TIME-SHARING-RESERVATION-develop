<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationManageRentalSpaceResult
{
    public int $rentalSpaceId;
    public string $spaceName;

    /**
     * @param int $rentalSpaceId
     * @param string $spaceName
     */
    public function __construct(
        int $rentalSpaceId,
        string $spaceName
    ){
        $this->spaceName = $spaceName;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
