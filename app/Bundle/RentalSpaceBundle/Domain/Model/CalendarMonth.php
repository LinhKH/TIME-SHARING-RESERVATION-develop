<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;


use App\Bundle\Common\Constants\DateTimeConst;
use DateTime;
use Exception;

final class CalendarMonth
{

    private int $month;
    private int $year;

    public function __construct(
        int $month,
        int $year
    ){
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @throws Exception
     */
    public function getDaysInMonth(): array
    {
        $date = DateTime::createFromFormat(DateTimeConst::FORMAT_YM, $this->getYear() . "-" . $this->getMonth());
        $result = [];
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $result[] = DateTime::createFromFormat(DateTimeConst::FORMAT_YMD, $this->getYear() . "-" . $this->getMonth() . "-" . $i);
        }
        return $result;
    }
}
