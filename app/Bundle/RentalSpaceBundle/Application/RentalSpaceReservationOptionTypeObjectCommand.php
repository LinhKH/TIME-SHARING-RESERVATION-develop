<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceReservationOptionTypeObjectCommand
{
    public ?string $titleJa;
    public ?string $descriptionJa;
    public ?int $price;
    public ?int $priceWithFraction;
    public ?string $unitType;
    public ?int $active;
    public ?int $orderNumber;

    /**
     * @param string|null $titleJa
     * @param string|null $descriptionJa
     * @param int|null $price
     * @param int|null $priceWithFraction
     * @param string|null $unitType
     * @param int|null $active
     * @param int|null $orderNumber
     */
    public function __construct(
        ?string $titleJa,
        ?string $descriptionJa,
        ?int $price,
        ?int $priceWithFraction,
        ?string $unitType,
        ?int $active,
        ?int $orderNumber
    ){
        $this->orderNumber = $orderNumber;
        $this->active = $active;
        $this->unitType = $unitType;
        $this->priceWithFraction = $priceWithFraction;
        $this->price = $price;
        $this->descriptionJa = $descriptionJa;
        $this->titleJa = $titleJa;
    }
}
