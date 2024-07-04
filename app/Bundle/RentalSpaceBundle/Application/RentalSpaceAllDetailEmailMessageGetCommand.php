<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceAllDetailEmailMessageGetCommand
{
    /**
     * @var int
     */
    public int $rentalSpaceId;

    /**
     * RentalSpaceAllDetailEmailMessageGetCommand constructor.
     * @param int $rentalSpaceId
     */
    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
