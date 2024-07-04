<?php

namespace App\Bundle\TourBundle\Domain\Model;

final class RentalSpaceResult
{
    /**
     * @var int
     */
    public int $rentalSpaceId;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $tourFlag;

    /**
     * RentalSpaceResult constructor.
     * @param int $rentalSpaceId
     * @param string $name
     * @param int $tourFlag
     */
    public function __construct(int $rentalSpaceId, string $name, int $tourFlag)
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->name = $name;
        $this->tourFlag = $tourFlag;
    }
}
