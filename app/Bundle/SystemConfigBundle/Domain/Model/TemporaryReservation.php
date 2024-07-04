<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class TemporaryReservation
{
    private ?int $allowedDaysAhead;
    private ?int $dueDaysCancel;
    private ?int $dueMonthsCancel;
    private ?int $monthsAsLongterm;
    private ?int $daysNotifyCancelation;

    /**
     * @param int $allowedDaysAhead allowedDaysAhead
     * @param int $dueDaysCancel dueDaysCancel
     * @param int $dueMonthsCancel dueMonthsCancel
     * @param int $monthsAsLongterm monthsAsLongterm
     * @param int $daysNotifyCancelation daysNotifyCancelation
     */
    public function __construct(
        ?int $allowedDaysAhead,
        ?int $dueDaysCancel,
        ?int $dueMonthsCancel,
        ?int $monthsAsLongterm,
        ?int $daysNotifyCancelation
    ) {
        $this->allowedDaysAhead = $allowedDaysAhead;
        $this->dueDaysCancel = $dueDaysCancel;
        $this->dueMonthsCancel = $dueMonthsCancel;
        $this->monthsAsLongterm = $monthsAsLongterm;
        $this->daysNotifyCancelation = $daysNotifyCancelation;
    }

    /**
     * @return int|null
     */
    public function getAllowedDaysAhead(): ?int
    {
        return $this->allowedDaysAhead;
    }

    /**
     * @return int|null
     */
    public function getDueDaysCancel(): ?int
    {
        return $this->dueDaysCancel;
    }

    /**
     * @return int|null
     */
    public function getDueMonthsCancel(): ?int
    {
        return $this->dueMonthsCancel;
    }

    /**
     * @return int|null
     */
    public function getMonthsAsLongterm(): ?int
    {
        return $this->monthsAsLongterm;
    }

    /**
     * @return int|null
     */
    public function getDaysNotifyCancelation(): ?int
    {
        return $this->daysNotifyCancelation;
    }
}
