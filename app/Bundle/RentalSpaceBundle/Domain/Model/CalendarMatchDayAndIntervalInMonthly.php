<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Constants\DateTimeConst;

final class CalendarMatchDayAndIntervalInMonthly
{
    private const MONDAY = 'Mon';
    private const TUESDAY = 'Tue';
    private const WEDNESDAY = 'Wed';
    private const THURSDAY = 'Thu';
    private const FRIDAY= 'Fri';
    private const SATURDAY = 'Sat';
    private const SUNDAY = 'Sun';

    private array $daysInMonth;
    private CalendarIntervalsInWeek $intervalsInWeek;

    /**
     * @param array $daysInMonth
     * @param CalendarIntervalsInWeek $intervalsInWeek
     */
    public function __construct(
        array $daysInMonth,
        CalendarIntervalsInWeek $intervalsInWeek
    ){
        $this->intervalsInWeek = $intervalsInWeek;
        $this->daysInMonth = $daysInMonth;
    }

    /**
     * @return array
     */
    public function getDaysInMonth(): array
    {
        return $this->daysInMonth;
    }

    /**
     * @return CalendarIntervalsInWeek
     */
    public function getIntervalsInWeek(): CalendarIntervalsInWeek
    {
        return $this->intervalsInWeek;
    }

    /**
     * @return array
     */
    public function getIntervalOfDaysInMonthly(): array
    {
        $intervalDaysInMonthLy = [];
        foreach ($this->getDaysInMonth() as $day) {
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::MONDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getMondayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::TUESDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getTuesdayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::WEDNESDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getWednesdayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::THURSDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getThursdayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::FRIDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getFridayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::SATURDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getSaturdayInterval()
                ];
                continue;
            }
            if ($day->format(DateTimeConst::FORMAT_DAY) === self::SUNDAY){
                $intervalDaysInMonthLy[] = [
                    'date' => $day->format(DateTimeConst::FORMAT_YMD),
                    'interval' => $this->getIntervalsInWeek()->getSundayInterval()
                ];
            }
        }
        return $intervalDaysInMonthLy;
    }
}
