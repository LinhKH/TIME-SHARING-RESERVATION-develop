<?php

namespace App\Bundle\TourBundle\Application;

final class TourNonApprovalCommand
{
    public int $tourId;
    public int $noReason;
    public ?string $substitudeFirstChoiceDate;
    public ?string $substitudeFirstChoiceTime;
    public ?string $substitudeSecondChoiceDate;
    public ?string $substitudeSecondChoiceTime;
    public ?string $substitudeThirdChoiceDate;
    public ?string $substitudeThirdChoiceTime;

    /**
     * TourNonApprovalCommand constructor.
     * @param int $tourId
     * @param int $noReason
     * @param string|null $substitudeFirstChoiceDate
     * @param string|null $substitudeFirstChoiceTime
     * @param string|null $substitudeSecondChoiceDate
     * @param string|null $substitudeSecondChoiceTime
     * @param string|null $substitudeThirdChoiceDate
     * @param string|null $substitudeThirdChoiceTime
     */
    public function __construct(
        int $tourId,
        int $noReason,
        ?string $substitudeFirstChoiceDate,
        ?string $substitudeFirstChoiceTime,
        ?string $substitudeSecondChoiceDate,
        ?string $substitudeSecondChoiceTime,
        ?string $substitudeThirdChoiceDate,
        ?string $substitudeThirdChoiceTime
    )
    {
        $this->tourId = $tourId;
        $this->noReason = $noReason;
        $this->substitudeFirstChoiceDate = $substitudeFirstChoiceDate;
        $this->substitudeFirstChoiceTime = $substitudeFirstChoiceTime;
        $this->substitudeSecondChoiceDate = $substitudeSecondChoiceDate;
        $this->substitudeSecondChoiceTime = $substitudeSecondChoiceTime;
        $this->substitudeThirdChoiceDate = $substitudeThirdChoiceDate;
        $this->substitudeThirdChoiceTime = $substitudeThirdChoiceTime;
    }
}
