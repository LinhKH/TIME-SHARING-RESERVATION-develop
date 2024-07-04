<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class NearTransportationGetResult
{
    public int $transportationId;
    public string $transportationName;
    public ?string $ref;
    public int $walkingDuration;
    public ?string $route;
    public ?int $nearTransportationId;


    /**
     * @param int $transportationId
     * @param string $transportationName
     * @param string|null $ref
     * @param int $walkingDuration
     * @param string|null $route
     * @param int|null $nearTransportationId
     */
    public function __construct(
        int $transportationId,
        string $transportationName,
        ?string $ref,
        int $walkingDuration,
        ?string $route,
        ?int $nearTransportationId
    ){
        $this->route = $route;
        $this->walkingDuration = $walkingDuration;
        $this->ref = $ref;
        $this->transportationName = $transportationName;
        $this->transportationId = $transportationId;
        $this->nearTransportationId = $nearTransportationId;
    }
}
