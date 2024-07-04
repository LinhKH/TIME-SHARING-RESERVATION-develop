<?php

namespace App\Bundle\CustomerBundle\Domain\Model;

use App\Bundle\Common\Constants\DateTimeConst;
use DateTime;

class SettingTime
{
    private DateTime $time;

    /**
     * @param DateTime $time time
     */
    public function __construct(
        DateTime $time
    ) {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time->format(DateTimeConst::FORMAT);
    }

    /**
     * @return int
     */
    public function getTimeStamps(): int
    {

        return strtotime($this->getTime());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->getTime()}";
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->time->format(DateTimeConst::FORMAT);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->time->format(DateTimeConst::FORMAT_YMD);
    }
}
