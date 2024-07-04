<?php


namespace App\Bundle\TourBundle\Application;


final class TourPostCommand
{
    public int $customerId;
    public int $rentalSpaceId;
    public string $firstChoiceDate;
    public string $firstChoiceTime;
    public ?string $secondChoiceDate;
    public ?string $secondChoiceTime;
    public ?string $thirdChoiceDate;
    public ?string $thirdChoiceTime;
    public ?string $fourthChoiceDate;
    public ?string $fourthChoiceTime;
    public string $usePlansDate;
    public int $usePlansPeople;
    public string $usePurpose;
    public string $usePurposeDetail;
    public string $checklist;

    public function __construct(
        int $customerId,
        int $rentalSpaceId,
        string $firstChoiceDate,
        string $firstChoiceTime,
        ?string $secondChoiceDate,
        ?string $secondChoiceTime,
        ?string $thirdChoiceDate,
        ?string $thirdChoiceTime,
        ?string $fourthChoiceDate,
        ?string $fourthChoiceTime,
        string $usePlansDate,
        string $usePlansPeople,
        string $usePurpose,
        string $usePurposeDetail,
        string $checklist
    )
    {
        $this->customerId = $customerId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->firstChoiceDate = $firstChoiceDate;
        $this->firstChoiceTime = $firstChoiceTime;
        $this->secondChoiceDate = $secondChoiceDate;
        $this->secondChoiceTime = $secondChoiceTime;
        $this->thirdChoiceDate = $thirdChoiceDate;
        $this->thirdChoiceTime = $thirdChoiceTime;
        $this->fourthChoiceDate = $fourthChoiceDate;
        $this->fourthChoiceTime = $fourthChoiceTime;
        $this->usePlansDate = $usePlansDate;
        $this->usePlansPeople = $usePlansPeople;
        $this->usePurpose = $usePurpose;
        $this->usePurposeDetail = $usePurposeDetail;
        $this->checklist = $checklist;
    }
}

