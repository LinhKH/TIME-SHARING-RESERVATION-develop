<?php

namespace App\Bundle\TourBundle\Application;

final class TourResult
{
    public int $tourId;
    public string $customerName;
    public string $rentalSpaceName;
    public string $firstChoiceDate;
    public ?string $secondChoiceDate;
    public ?string $thirdChoiceDate;
    public ?string $fixChoiceDateName;
    public ?string $fixChoiceTimeName;
    public ?string $subFirstChoiceDate;
    public ?string $subSecondChoiceDate;
    public ?string $subThirdChoiceDate;
    public string $usePlansDate;
    public int $usePlansPeople;
    public string $usePurpose;
    public string $usePurposeDetail;
    public string $checklist;
    public string $tourStatus;
    public ?string $entryTime;

    /**
     * TourResult constructor.
     * @param int $tourId
     * @param string $customerName
     * @param string $rentalSpaceName
     * @param string $firstChoiceDate
     * @param string|null $secondChoiceDate
     * @param string|null $thirdChoiceDate
     * @param string|null $fixChoiceDateName
     * @param string|null $fixChoiceTimeName
     * @param string|null $subFirstChoiceDate
     * @param string|null $subSecondChoiceDate
     * @param string|null $subThirdChoiceDate
     * @param string $usePlansDate
     * @param string $usePlansPeople
     * @param string $usePurpose
     * @param string $usePurposeDetail
     * @param string $checklist
     * @param string $tourStatus
     * @param string|null $entryTime
     */
    public function __construct(
        int     $tourId,
        string  $customerName,
        string  $rentalSpaceName,
        string  $firstChoiceDate,
        ?string $secondChoiceDate,
        ?string $thirdChoiceDate,
        ?string $fixChoiceDateName,
        ?string $fixChoiceTimeName,
        ?string $subFirstChoiceDate,
        ?string $subSecondChoiceDate,
        ?string $subThirdChoiceDate,
        string  $usePlansDate,
        string  $usePlansPeople,
        string  $usePurpose,
        string  $usePurposeDetail,
        string  $checklist,
        string  $tourStatus,
        ?string $entryTime
    )
    {
        $this->tourId = $tourId;
        $this->customerName = $customerName;
        $this->rentalSpaceName = $rentalSpaceName;
        $this->firstChoiceDate = $firstChoiceDate;
        $this->secondChoiceDate = $secondChoiceDate;
        $this->thirdChoiceDate = $thirdChoiceDate;
        $this->fixChoiceTimeName = $fixChoiceTimeName;
        $this->fixChoiceDateName = $fixChoiceDateName;
        $this->subSecondChoiceDate = $subSecondChoiceDate;
        $this->subThirdChoiceDate = $subThirdChoiceDate;
        $this->subFirstChoiceDate = $subFirstChoiceDate;
        $this->usePlansDate = $usePlansDate;
        $this->usePlansPeople = $usePlansPeople;
        $this->usePurpose = $usePurpose;
        $this->usePurposeDetail = $usePurposeDetail;
        $this->checklist = $checklist;
        $this->tourStatus = $tourStatus;
        $this->entryTime = $entryTime;
    }
}
