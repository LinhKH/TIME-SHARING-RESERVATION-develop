<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteImageCommand
{
    /**
     * @var string
     */
    public string $imageId;

    /**
     * RentalSpaceDeleteImageCommand constructor.
     * @param string $imageId
     */
    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }
}
