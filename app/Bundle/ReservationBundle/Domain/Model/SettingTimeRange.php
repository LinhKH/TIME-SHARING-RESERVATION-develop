<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use DateTime;

final class SettingTimeRange
{
    private DateTime $startTime;
    private DateTime $endTime;

    /**
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @throws InvalidArgumentException
     */
    public function __construct(
        DateTime $startTime,
        DateTime $endTime
    ){
        if (!self::isValidTimeRange($startTime, $endTime)) {
            throw new InvalidArgumentException("不正な値です。");
        }
        $this->endTime = $endTime;
        $this->startTime = $startTime;
    }

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    /**
     * @return DateTime
     */
    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    /**
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @return bool
     */
    public static function isValidTimeRange(DateTime $startTime, DateTime $endTime): bool
    {
        if (empty($startTime) || empty($endTime) || $startTime->getTimestamp() > $endTime->getTimestamp()
        ) {
            return false;
        }

        return true;
    }
}
