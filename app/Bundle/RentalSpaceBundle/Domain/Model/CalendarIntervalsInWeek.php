<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class CalendarIntervalsInWeek
{
    private array $mondayInterval;
    private array $tuesdayInterval;
    private array $wednesdayInterval;
    private array $fridayInterval;
    private array $thursdayInterval;
    private array $saturdayInterval;
    private array $sundayInterval;

    /**
     * @param array $mondayInterval
     * @param array $tuesdayInterval
     * @param array $wednesdayInterval
     * @param array $thursdayInterval
     * @param array $fridayInterval
     * @param array $saturdayInterval
     * @param array $sundayInterval
     */
    public function __construct(
        array $mondayInterval,
        array $tuesdayInterval,
        array $wednesdayInterval,
        array $thursdayInterval,
        array $fridayInterval,
        array $saturdayInterval,
        array $sundayInterval
    ){
        $this->sundayInterval = $sundayInterval;
        $this->saturdayInterval = $saturdayInterval;
        $this->thursdayInterval = $thursdayInterval;
        $this->fridayInterval = $fridayInterval;
        $this->wednesdayInterval = $wednesdayInterval;
        $this->tuesdayInterval = $tuesdayInterval;
        $this->mondayInterval = $mondayInterval;

    }

    /**
     * @return array
     */
    public function getMondayInterval(): array
    {
        return $this->mondayInterval;
    }

    /**
     * @return array
     */
    public function getTuesdayInterval(): array
    {
        return $this->tuesdayInterval;
    }

    /**
     * @return array
     */
    public function getWednesdayInterval(): array
    {
        return $this->wednesdayInterval;
    }

    /**
     * @return array
     */
    public function getFridayInterval(): array
    {
        return $this->fridayInterval;
    }

    /**
     * @return array
     */
    public function getThursdayInterval(): array
    {
        return $this->thursdayInterval;
    }

    /**
     * @return array
     */
    public function getSaturdayInterval(): array
    {
        return $this->saturdayInterval;
    }

    /**
     * @return array
     */
    public function getSundayInterval(): array
    {
        return $this->sundayInterval;
    }

}
