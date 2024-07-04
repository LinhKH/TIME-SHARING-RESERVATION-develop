<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeletePanoramaImageResult
{
    /**
     * @var string
     */
    public string $message;

    /**
     * RentalSpaceDeletePanoramaImageResult constructor.
     * @param string $message
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }
}
