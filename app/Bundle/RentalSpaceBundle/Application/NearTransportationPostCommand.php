<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class NearTransportationPostCommand
{
    public int $rentalSpaceId;
    public ?int $transportationStationId;
    public int $walkingDuration;
    public ?string $ref;

    /**
     * @param int $rentalSpaceId
     * @param int|null $transportationStationId
     * @param int $walkingDuration
     * @param string|null $ref
     */
    public function __construct(
        int $rentalSpaceId,
        ?int $transportationStationId,
        int $walkingDuration,
        ?string $ref
    ){
        $this->ref = $ref;
        $this->walkingDuration = $walkingDuration;
        $this->transportationStationId = $transportationStationId;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
