<?php

namespace App\Bundle\TourBundle\Application;

class TourNonApprovalResult
{
    /**
     * @var int
     */
    public int $tourId;

    /**
     * TourNonApprovalResult constructor.
     * @param int $tourId
     */
    public function __construct(
        int $tourId
    )
    {
        $this->tourId = $tourId;
    }
}
