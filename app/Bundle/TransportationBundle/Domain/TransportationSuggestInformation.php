<?php

namespace App\Bundle\TransportationBundle\Domain;

final class TransportationSuggestInformation
{
    private TransportationId $transportationId;
    private string $transportationName;
    private ?string $ref;
    private string $route;

    /**
     * @param TransportationId $transportationId
     * @param string $transportationName
     * @param string|null $ref
     * @param string $route
     */
    public function __construct(
        TransportationId $transportationId,
        string $transportationName,
        ?string $ref,
        string $route

    ){
        $this->route = $route;
        $this->ref = $ref;
        $this->transportationName = $transportationName;
        $this->transportationId = $transportationId;
    }

    /**
     * @return TransportationId
     */
    public function getTransportationId(): TransportationId
    {
        return $this->transportationId;
    }

    /**
     * @return string
     */
    public function getTransportationName(): string
    {
        return $this->transportationName;
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}
