<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class ConciergeWorkingTimesConfiguration
{
    private SettingTimeRange $monday;
    private SettingTimeRange $tuesday;
    private SettingTimeRange $wednesday;
    private SettingTimeRange $thursday;
    private SettingTimeRange $friday;
    private SettingTimeRange $saturday;
    private SettingTimeRange $sunday;

    /**
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $monday monday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $tuesday tuesday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $wednesday wednesday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $thursday thursday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $friday friday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $saturday saturday
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange $sunday sunday
     */
    public function __construct(
        SettingTimeRange $monday,
        SettingTimeRange $tuesday,
        SettingTimeRange $wednesday,
        SettingTimeRange $thursday,
        SettingTimeRange $friday,
        SettingTimeRange $saturday,
        SettingTimeRange $sunday
    ) {
        $this->monday = $monday;
        $this->tuesday = $tuesday;
        $this->wednesday = $wednesday;
        $this->thursday = $thursday;
        $this->friday = $friday;
        $this->saturday = $saturday;
        $this->sunday = $sunday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getMonday(): SettingTimeRange
    {
        return $this->monday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getTuesday(): SettingTimeRange
    {
        return $this->tuesday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getWednesday(): SettingTimeRange
    {
        return $this->wednesday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getThursday(): SettingTimeRange
    {
        return $this->thursday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getFriday(): SettingTimeRange
    {
        return $this->friday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getSaturday(): SettingTimeRange
    {
        return $this->saturday;
    }

    /**
     * @return SettingTimeRange
     */
    public function getSunday(): SettingTimeRange
    {
        return $this->sunday;
    }
}
