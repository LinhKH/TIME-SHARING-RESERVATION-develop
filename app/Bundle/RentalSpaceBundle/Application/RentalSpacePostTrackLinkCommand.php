<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostTrackLinkCommand
{
    public int $type;
    public string $name;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param string $name
     * @param int $type
     */
    public function __construct(
        int $rentalSpaceId,
        string $name,
        int $type
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->name = $name;
        $this->type = $type;
    }
}
