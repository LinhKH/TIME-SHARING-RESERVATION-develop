<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalIntervalStartEndTimeFormatted
{
    private string $startTimeFormatted;
    private string $endTimeFormatted;

    /**
     * @param string $startTimeFormatted
     * @param string $endTimeFormatted
     */
    public function __construct(
        string $startTimeFormatted,
        string $endTimeFormatted
    )
    {
        $this->endTimeFormatted = $endTimeFormatted;
        $this->startTimeFormatted = $startTimeFormatted;
    }

    /**
     * @return string
     */
    public function getStartTimeFormatted(): string
    {
        return $this->startTimeFormatted;
    }

    /**
     * @return string
     */
    public function getEndTimeFormatted(): string
    {
        return $this->endTimeFormatted;
    }
}
