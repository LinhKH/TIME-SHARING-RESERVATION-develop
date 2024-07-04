<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeletePanoramaImageCommand
{
    /**
     * @var string
     */
    public string $imageId;

    /**
     * RentalSpaceDeletePanoramaImageCommand constructor.
     * @param string $imageId
     */
    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }
}
