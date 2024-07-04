<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceReservationOptionTypeObject
{
    private ?string $titleJa;
    private ?string $descriptionJa;
    private ?int $price;
    private ?int $priceWithFraction;
    private ?string $unitType;
    private ?int $active;
    private ?int $orderNumber;

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

    /**
     * @return string|null
     */
    public function getTitleJa(): ?string
    {
        return $this->titleJa;
    }

    /**
     * @return string|null
     */
    public function getDescriptionJa(): ?string
    {
        return $this->descriptionJa;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @return int|null
     */
    public function getPriceWithFraction(): ?int
    {
        return $this->priceWithFraction;
    }

    /**
     * @return string|null
     */
    public function getUnitType(): ?string
    {
        return $this->unitType;
    }

    /**
     * @return int|null
     */
    public function getActive(): ?int
    {
        return $this->active;
    }

    /**
     * @return int|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }


}
