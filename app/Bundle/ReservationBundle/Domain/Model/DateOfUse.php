<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Constants\DateTimeConst;
use DateTime;

final class DateOfUse
{
    private DateTime $day;

    /**
     * @param DateTime $day
     */
    public function __construct(
        DateTime $day
    )
    {
        $this->day = $day;
    }

    /**
     * @return DateTime
     */
    public function getDay(): DateTime
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return  $this->day->format(DateTimeConst::FORMAT);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return  $this->day->format(DateTimeConst::FORMAT_YMD);
    }

}
