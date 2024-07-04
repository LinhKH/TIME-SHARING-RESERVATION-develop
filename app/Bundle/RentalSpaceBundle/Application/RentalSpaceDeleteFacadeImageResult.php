<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDeleteFacadeImageResult
{
    /**
     * @var string
     */
    public string $message;

    /**
     * RentalSpaceDeleteFacadeImageResult constructor.
     * @param string $message
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }
}
