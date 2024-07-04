<?php

namespace App\Bundle\TourBundle\Application;

final class TourApprovalCommand
{
    /**
     * @var int
     */
    public int $tourId;

    /**
     * @var string
     */
    public string $tourDate;

    /**
     * TourApprovalCommand constructor.
     * @param int $tourId
     * @param string $tourDate
     */
    public function __construct(
        int $tourId,
        string $tourDate
    )
    {
        $this->tourId = $tourId;
        $this->tourDate = $tourDate;
    }
}
