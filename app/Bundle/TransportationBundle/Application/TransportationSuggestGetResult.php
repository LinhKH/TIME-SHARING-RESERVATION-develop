<?php

namespace App\Bundle\TransportationBundle\Application;

class TransportationSuggestGetResult
{
    public int $transportationId;
    public string $transportationName;
    public ?string $ref;
    public string $route;

    /**
     * @param int $transportationId
     * @param string $transportationName
     * @param string|null $ref
     * @param string $route
     */
    public function __construct(
        int $transportationId,
        string $transportationName,
        ?string $ref,
        string $route

    ){
        $this->route = $route;
        $this->ref = $ref;
        $this->transportationName = $transportationName;
        $this->transportationId = $transportationId;
    }
}
