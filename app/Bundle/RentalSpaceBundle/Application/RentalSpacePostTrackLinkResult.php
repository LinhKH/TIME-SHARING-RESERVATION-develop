<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostTrackLinkResult
{
    public string $type;
    public string $name;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param string $name
     * @param string $type
     */
    public function __construct(
        int $rentalSpaceId,
        string $name,
        string $type
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->name = $name;
        $this->type = $type;
    }
}
