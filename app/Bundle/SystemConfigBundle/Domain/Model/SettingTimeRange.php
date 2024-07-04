<?php
namespace App\Bundle\SystemConfigBundle\Domain\Model;

use Carbon\Traits\Date;
use DateTime;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class SettingTimeRange
{
    private ?DateTime $start;
    private ?DateTime $end;

    /**
     * SettingTimeRange constructor.
     * @param DateTime|null $start
     * @param DateTime|null $end
     */
    public function __construct(
        ?DateTime $start,
        ?DateTime $end
    ) {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTime
     */
    public function getStart(): ?string
    {
        if (empty($this->start)) {
            return null;
        }
        return $this->start->format("H:i");
    }

    /**
     * @return DateTime
     */
    public function getEnd(): ?string
    {
        if (empty($this->end)) {
            return null;
        }
        return $this->end->format("H:i");
    }

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return "{$this->getStart()} - {$this->getEnd()}";
    }
}
