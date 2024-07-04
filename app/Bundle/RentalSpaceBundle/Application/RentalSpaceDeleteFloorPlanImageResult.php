<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteFloorPlanImageResult
{
    /**
     * @var string
     */
    public string $message;

    /**
     * RentalSpaceDeleteFloorPlanImageResult constructor.
     * @param string $message
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }
}
