<?php

namespace App\Bundle\TourBundle\Domain\Model;

final class TourNonApproval
{
    private TourId $tourId;
    private NoReason $noReason;
    private ChoiceDate $substitudeFirstChoiceDate;
    private ChoiceDate $substitudeSecondChoiceDate;
    private ChoiceDate $substitudeThirdChoiceDate;
    private TourStatus $tourStatus;

    /**
     * TourNonApproval constructor.
     * @param TourId $tourId
     * @param NoReason $noReason
     * @param ChoiceDate $substitudeFirstChoiceDate
     * @param ChoiceDate $substitudeSecondChoiceDate
     * @param ChoiceDate $substitudeThirdChoiceDate
     * @param TourStatus $tourStatus
     */
    public function __construct(
        TourId $tourId,
        NoReason $noReason,
        ChoiceDate $substitudeFirstChoiceDate,
        ChoiceDate $substitudeSecondChoiceDate,
        ChoiceDate $substitudeThirdChoiceDate,
        TourStatus $tourStatus
    )
    {
        $this->tourId = $tourId;
        $this->noReason = $noReason;
        $this->substitudeFirstChoiceDate = $substitudeFirstChoiceDate;
        $this->substitudeSecondChoiceDate = $substitudeSecondChoiceDate;
        $this->substitudeThirdChoiceDate = $substitudeThirdChoiceDate;
        $this->tourStatus = $tourStatus;
    }

    /**
     * @return TourId
     */
    public function getTourId(): TourId
    {
        return $this->tourId;
    }

    /**
     * @return NoReason
     */
    public function getNoReason(): NoReason
    {
        return $this->noReason;
    }

    /**
     * @return ChoiceDate
     */
    public function getSubstitudeFirstChoiceDate(): ChoiceDate {
        return $this->substitudeFirstChoiceDate;
    }

    /**
     * @return ChoiceDate
     */
    public function getSubstitudeSecondChoiceDate(): ChoiceDate
    {
        return $this->substitudeSecondChoiceDate;
    }

    /**
     * @return ChoiceDate
     */
    public function getSubstitudeThirdChoiceDate(): ChoiceDate
    {
        return $this->substitudeThirdChoiceDate;
    }

    /**
     * @return TourStatus
     */
    public function getTourStatus(): TourStatus
    {
        return $this->tourStatus;
    }
}
