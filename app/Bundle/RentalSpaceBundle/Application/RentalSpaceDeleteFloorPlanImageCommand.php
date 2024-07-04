<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteFloorPlanImageCommand
{
    /**
     * @var string
     */
    public string $imageId;

    /**
     * RentalSpaceDeleteFloorPlanImageCommand constructor.
     * @param string $imageId
     */
    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }
}
