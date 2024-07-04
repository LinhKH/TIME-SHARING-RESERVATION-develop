<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteDirectionStationImageResult
{
    /**
     * @var string
     */
    public string $message;

    /**
     * RentalSpaceDeleteDirectionStationImageResult constructor.
     * @param string $message
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }
}
