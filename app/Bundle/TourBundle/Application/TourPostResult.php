<?php


namespace App\Bundle\TourBundle\Application;


final class TourPostResult
{
    /**
     * @var int
     */
    public int $tourId;

    public function __construct(
        int $tourId
    )
    {
        $this->tourId = $tourId;
    }
}

