<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteFacadeImageCommand
{
    /**
     * @var string
     */
    public string $imageId;

    /**
     * RentalSpaceDeleteFacadeImageCommand constructor.
     * @param string $imageId
     */
    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }
}
