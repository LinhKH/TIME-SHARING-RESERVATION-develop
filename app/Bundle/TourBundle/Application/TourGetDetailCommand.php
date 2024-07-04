<?php

namespace App\Bundle\TourBundle\Application;

final class TourGetDetailCommand
{
    /**
     * @var int
     */
    public int $tourId;

    /**
     * TourGetDetailCommand constructor.
     * @param int $tourId
     */
    public function __construct(
        int $tourId
    ) {
        $this->tourId = $tourId;
    }
}
