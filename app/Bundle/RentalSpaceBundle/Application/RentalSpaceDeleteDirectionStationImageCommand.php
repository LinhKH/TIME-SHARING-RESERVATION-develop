<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteDirectionStationImageCommand
{
    /**
     * @var string
     */
    public string $imageId;

    /**
     * RentalSpaceDeleteDirectionStationImageCommand constructor.
     * @param string $imageId
     */
    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }
}
