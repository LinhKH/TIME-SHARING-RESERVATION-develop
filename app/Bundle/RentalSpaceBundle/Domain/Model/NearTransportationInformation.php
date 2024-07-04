<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\TransportationBundle\Domain\TransportationId;

final class NearTransportationInformation
{
    public ?int $nearTransportationId;
    private RentalSpaceId $rentalSpaceId;
    private ?TransportationId $transportationStationId;
    private int $walkingDuration;
    private ?string $ref;
    private ?string $transportationName;
    private ?string $route;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param TransportationId|null $transportationStationId
     * @param int $walkingDuration
     * @param string|null $ref
     * @param string|null $transportationName
     * @param string|null $route
     * @param int|null $nearTransportationId
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        ?TransportationId $transportationStationId,
        int $walkingDuration,
        ?string $ref,
        ?string $transportationName,
        ?string $route,
        ?int $nearTransportationId
    ){
        $this->nearTransportationId = $nearTransportationId;
        $this->route = $route;
        $this->transportationName = $transportationName;
        $this->ref = $ref;
        $this->walkingDuration = $walkingDuration;
        $this->transportationStationId = $transportationStationId;
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
     * @return TransportationId|null
     */
    public function getTransportationStationId(): ?TransportationId
    {
        return $this->transportationStationId;
    }

    /**
     * @return int
     */
    public function getWalkingDuration(): int
    {
        return $this->walkingDuration;
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @return string|null
     */
    public function getTransportationName(): ?string
    {
        return $this->transportationName;
    }

    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return int|null
     */
    public function getNearTransportationId(): ?int
    {
        return $this->nearTransportationId;
    }

}
