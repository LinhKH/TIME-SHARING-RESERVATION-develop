<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalIntervalGroupThisDay
{
    private const ALL = 'all';
    private const MONDAY = 'day.monday';
    private const TUESDAY = 'day.tuesday';
    private const WEDNESDAY = 'day.wednesday';
    private const THURSDAY = 'day.thursday';
    private const FRIDAY= 'day.friday';
    private const SATURDAY = 'day.saturday';
    private const SUNDAY = 'day.sunday';

    private array $intervals;

    /**
     * @param RentalIntervalInformation[] $intervals
     */
    public function __construct(
        array $intervals
    ){
        $this->intervals = $intervals;
    }

    /**
     * @return array
     */
    public function getIntervals(): array
    {
        return $this->intervals;
    }

    /**
     * @return array|array[]
     */
    public function getIntervalGroupThisDay(): array
    {
        $resultDayIntervals = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => []
        ];

        foreach ($this->intervals as $interval) {
            if (empty($interval)) {
                foreach ($resultDayIntervals as $day) {
                    $day[] = $interval;
                }
            }
            if (in_array(self::ALL, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['monday'][] = $interval;
                $resultDayIntervals['tuesday'][] = $interval;
                $resultDayIntervals['wednesday'][] = $interval;
                $resultDayIntervals['thursday'][] = $interval;
                $resultDayIntervals['friday'][] = $interval;
                $resultDayIntervals['saturday'][] = $interval;
                $resultDayIntervals['sunday'][] = $interval;
            }
            if (in_array(self::MONDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['monday'][] = $interval;
            }
            if (in_array(self::TUESDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['tuesday'][] = $interval;
            }
            if (in_array(self::WEDNESDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['wednesday'][] = $interval;
            }
            if (in_array(self::THURSDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['thursday'][] = $interval;
            }
            if (in_array(self::FRIDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['friday'][] = $interval;
            }
            if (in_array(self::SATURDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['saturday'][] = $interval;
            }
            if (in_array(self::SUNDAY, $interval->getApplicabilityPeriods())) {
                $resultDayIntervals['sunday'][] = $interval;
            }
        }
        return $resultDayIntervals;
    }

    /**
     * @return array
     */
    public function getIntervalMonday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['monday'];
    }

    /**
     * @return array
     */
    public function getIntervalTuesday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['tuesday'];
    }
    /**
     * @return array
     */
    public function getIntervalWednesday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['wednesday'];
    }
    /**
     * @return array
     */
    public function getIntervalThursday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['thursday'];
    }
    /**
     * @return array
     */
    public function getIntervalFriday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['friday'];
    }
    /**
     * @return array
     */
    public function getIntervalSaturday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['saturday'];
    }
    /**
     * @return array
     */
    public function getIntervalSunday(): array
    {
        $intervalDaysInWeek = $this->getIntervalGroupThisDay();
        return $intervalDaysInWeek['sunday'];
    }
}
