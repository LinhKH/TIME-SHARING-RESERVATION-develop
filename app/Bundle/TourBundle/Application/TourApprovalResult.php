<?php

namespace App\Bundle\TourBundle\Application;

final class TourApprovalResult
{
    /**
     * @var int
     */
    public int $tourId;

    /**
     * TourApprovalResult constructor.
     * @param int $tourId
     */
    public function __construct(
        int $tourId
    )
    {
        $this->tourId = $tourId;
    }
}
