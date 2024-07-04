<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalIntervalDateAndTime
{
    private array $applicabilityPeriods;
    private string $endTimeFormatted;
    private string $startTimeFormatted;

    /**
     * @param array $applicabilityPeriods
     * @param string $startTimeFormatted
     * @param string $endTimeFormatted
     */
    public function __construct(
        array  $applicabilityPeriods,
        string $startTimeFormatted,
        string $endTimeFormatted
    )
    {
        $this->startTimeFormatted = $startTimeFormatted;
        $this->endTimeFormatted = $endTimeFormatted;
        $this->applicabilityPeriods = $applicabilityPeriods;

    }

    /**
     * @return array
     */
    public function getApplicabilityPeriods(): array
    {
        return $this->applicabilityPeriods;
    }

    /**
     * @return string
     */
    public function getEndTimeFormatted(): string
    {
        return $this->endTimeFormatted;
    }

    /**
     * @return string
     */
    public function getStartTimeFormatted(): string
    {
        return $this->startTimeFormatted;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        $days = [];
        foreach ($this->applicabilityPeriods as $applicabilityPeriod) {
            $days[] = [
                'applicabilityPeriod' => $applicabilityPeriod,
                'startTimeFormatted' => $this->startTimeFormatted,
                'endTimeFormatted' => $this->endTimeFormatted
            ];
        }
        return $days;
    }

    public function externalApplicabilityPeriod($day): bool
    {
        foreach ($this->getDays() as $rentalInterval) {
            if ($day['applicabilityPeriod'] !== $rentalInterval['applicabilityPeriod']) {
                continue;
            }
            if ($day['startTimeFormatted'] < $day['endTimeFormatted'] && $day['startTimeFormatted'] > $rentalInterval['endTimeFormatted']) {
                continue;
            }
            if ($day['startTimeFormatted'] < $day['endTimeFormatted'] && $day['endTimeFormatted'] < $rentalInterval['startTimeFormatted']) {
                continue;
            }
            return false;
        }
        return true;
    }
}
