<?php

namespace App\Bundle\TourBundle\Domain\Model;

use DateTime;

class ChoiceDate
{
    /**
     * @var DateTime|null
     */
    private ?DateTime $time;

    /**
     * @var DateTime|null
     */
    private ?DateTime $date;

    /**
     * ChoiceDate constructor.
     * @param DateTime|null $date
     * @param DateTime|null $time
     */
    public function __construct(
        ?DateTime $date,
        ?DateTime $time
    )
    {
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Get time of choice date
     * @return string|null
     */
    public function getTime(): ?string
    {
        if (empty($this->time)) {
            return null;
        }
        return $this->time->format("H:i");
    }

    /**
     * Get date of choice date
     * @return string|null
     */
    public function getDate(): ?string
    {
        if (empty($this->date)) {
            return null;
        }
        return $this->date->format("Y-m-d");
    }

    /**
     * @return string|null
     */
    public function asString(): ?string
    {
        $date_time = null;
        if (!empty($this->date)) {
            $date_time .= $this->date->format("Y-d-m");
        }
        if (!empty($this->time)) {
            if (!empty($date_time))
            {
                $date_time .= ' ';
            }
            $date_time .= $this->time->format("H:i:s");
        }
        return $date_time;
    }
}
