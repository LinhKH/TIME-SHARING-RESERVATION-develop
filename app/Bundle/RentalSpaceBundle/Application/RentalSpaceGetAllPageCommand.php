<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceGetAllPageCommand
{
    /**
     * @var int
     */
    public int $rentalSpaceId;

    /**
     * RentalSpaceGetAllPageCommand constructor.
     * @param int $rentalSpaceId
     */
    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
