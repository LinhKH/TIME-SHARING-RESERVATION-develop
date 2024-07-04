<?php


namespace App\Bundle\TourBundle\Domain\Model;


final class TourApproval
{
    /**
     * @var TourId
     */
    private TourId $tourId;

    /**
     * @var TourStatus
     */
    private TourStatus $tourStatus;

    /**
     * @var FixChoiceDate
     */
    private FixChoiceDate $fixChoiceDate;

    /**
     * TourApproval constructor.
     * @param TourId $tourId
     * @param TourStatus $tourStatus
     * @param FixChoiceDate $fixChoiceDate
     */
    public function __construct(
        TourId $tourId,
        TourStatus $tourStatus,
        FixChoiceDate $fixChoiceDate
    )
    {
        $this->tourId = $tourId;
        $this->tourStatus = $tourStatus;
        $this->fixChoiceDate = $fixChoiceDate;
    }

    /**
     * @return TourId
     */
    public function getTourId(): TourId
    {
        return $this->tourId;
    }

    /**
     * @return TourStatus
     */
    public function getTourStatus(): TourStatus
    {
        return $this->tourStatus;
    }

    /**
     * @return FixChoiceDate
     */
    public function getFixChoiceDate(): FixChoiceDate
    {
        return $this->fixChoiceDate;
    }
}
