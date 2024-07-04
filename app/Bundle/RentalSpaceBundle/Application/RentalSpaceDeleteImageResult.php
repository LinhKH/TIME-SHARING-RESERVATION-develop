<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteImageResult
{
    /**
     * @var string
     */
    public string $message;

    /**
     * RentalSpaceDeleteImageResult constructor.
     * @param string $message
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }
}
