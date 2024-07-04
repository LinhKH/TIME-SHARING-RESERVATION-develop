<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalIntervalTimeFormatted
{
    private string $startTimeFormatted;
    private string $endTimeFormatted;
    private RentalSpaceRentalIntervalMultiType $rentalIntervalMultiType;

    /**
     * @param string $startTimeFormatted
     * @param string $endTimeFormatted
     */
    public function __construct(
        RentalSpaceRentalIntervalMultiType $rentalIntervalMultiType,
        string                             $startTimeFormatted,
        string                             $endTimeFormatted
    )
    {
        $this->rentalIntervalMultiType = $rentalIntervalMultiType;
        $this->endTimeFormatted = $endTimeFormatted;
        $this->startTimeFormatted = $startTimeFormatted;
    }

    /**
     * @return string
     */
    public function getEndTimeFormatted(): string
    {
        return $this->endTimeFormatted;
    }

    /**
     * @param $value
     * @return mixed|string
     */
    public function setEndTimeFormatted($value)
    {
        $singleDigitTimeFormatRegex = "/^(\d{1}):(\d{2})$/";
        if (preg_match($singleDigitTimeFormatRegex, $value)) {
            $value = '0' . $value;
        }
        return $value;
    }

    /**
     * @return string
     */
    public function getStartTimeFormatted(): string
    {
        return $this->startTimeFormatted;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setStartTimeFormatted($value)
    {
        $singleDigitTimeFormatRegex = "/^(\d{1}):(\d{2})$/";
        if (preg_match($singleDigitTimeFormatRegex, $value)) {
            $value = '0' . $value;
        }
        return $value;
    }

    /**
     * @return RentalSpaceRentalIntervalMultiType
     */
    public function getRentalIntervalMultiType(): RentalSpaceRentalIntervalMultiType
    {
        return $this->rentalIntervalMultiType;
    }

    /**
     * @return array
     */
    public function handleTimeFormattedFrame(): array
    {

        $timeFormattedArray[] = new RentalSpaceRentalIntervalStartEndTimeFormatted(
            $this->getStartTimeFormatted(),
            $this->getEndTimeFormatted()
        );

        if ($this->getRentalIntervalMultiType()->isOneHour() || $this->getRentalIntervalMultiType()->isHalfHour()) {

            $interval = $this->getRentalIntervalMultiType()->getValue();
            $timeFormattedArray = [];

            //include date for calculation
            $startTime = date('Y/m/d H:i', strtotime($this->getStartTimeFormatted()));
            $endTime = date('Y/m/d H:i', strtotime($this->getEndTimeFormatted()));

            do{
                $setStartTime = $this->setStartTimeFormatted(date('H:i', strtotime($startTime)));
                $startTime = date('Y/m/d H:i', strtotime($interval, strtotime($startTime)));

                // Gán
                $setEndTime = $this->setEndTimeFormatted(date('H:i', strtotime($startTime)));

                $timeFormattedArray[] = new RentalSpaceRentalIntervalStartEndTimeFormatted(
                    $setStartTime,
                    $setEndTime
                );
            } while($startTime < $endTime);
        }

        return $timeFormattedArray;
    }
}
