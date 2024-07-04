<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use DateTime;

class Tour
{
    private ?TourId $tourId;
    private CustomerId $customerId;
    private ChoiceDate $firstChoiceDate;
    private ?ChoiceDate $secondChoiceDate;
    private ?ChoiceDate $thirdChoiceDate;
    private ?ChoiceDate $fourthChoiceDate;
    private ?ChoiceDate $substitudeFirstChoiceDate;
    private ?ChoiceDate $substitudeSecondChoiceDate;
    private ?ChoiceDate $substitudeThirdChoiceDate;
    private RentalSpaceId $rentalSpaceId;
    private OrganizationId $organizationId;
    private ?string $noReason;
    private TourStatus $status;
    private string $usePlansDate;
    private int $usePlansPeople;
    private string $usePurpose;
    private string $usePurposeDetail;
    private string $checklist;
    private ?DateTime $entryTime;
    private ?string $fixChoiceDateColumnName;
    private ?string $fixChoiceTimeColumnName;
    private UserViewFlg $userViewFlg;

    public function __construct(
        ?TourId $tourId,
        CustomerId $customerId,
        ChoiceDate $firstChoiceDate,
        ?ChoiceDate $secondChoiceDate,
        ?ChoiceDate $thirdChoiceDate,
        ?ChoiceDate $fourthChoiceDate,
        ?ChoiceDate $substitudeFirstChoiceDate,
        ?ChoiceDate $substitudeSecondChoiceDate,
        ?ChoiceDate $substitudeThirdChoiceDate,
        RentalSpaceId $rentalSpaceId,
        OrganizationId $organizationId,
        ?string $noReason,
        TourStatus $status,
        string $usePlansDate,
        int $usePlansPeople,
        string $usePurpose,
        string $usePurposeDetail,
        string $checklist,
        ?DateTime $entryTime,
        ?string $fixChoiceDateColumnName,
        ?string $fixChoiceTimeColumnName,
        UserViewFlg $userViewFlg
    )
    {
        $this->tourId = $tourId;
        $this->customerId = $customerId;
        $this->firstChoiceDate = $firstChoiceDate;
        $this->secondChoiceDate = $secondChoiceDate;
        $this->thirdChoiceDate = $thirdChoiceDate;
        $this->fourthChoiceDate = $fourthChoiceDate;
        $this->substitudeFirstChoiceDate = $substitudeFirstChoiceDate;
        $this->substitudeSecondChoiceDate = $substitudeSecondChoiceDate;
        $this->substitudeThirdChoiceDate = $substitudeThirdChoiceDate;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->organizationId = $organizationId;
        $this->noReason = $noReason;
        $this->status = $status;
        $this->usePlansDate = $usePlansDate;
        $this->usePlansPeople = $usePlansPeople;
        $this->usePurpose = $usePurpose;
        $this->usePurposeDetail = $usePurposeDetail;
        $this->checklist = $checklist;
        $this->entryTime = $entryTime;
        $this->fixChoiceDateColumnName = $fixChoiceDateColumnName;
        $this->fixChoiceTimeColumnName = $fixChoiceTimeColumnName;
        $this->userViewFlg = $userViewFlg;
    }

    /**
     * @return TourId|null
     */
    public function getTourId(): ?TourId
    {
        return $this->tourId;
    }

    /**
     * @return CustomerId
     */
    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    /**
     * @return ChoiceDate
     */
    public function getFirstChoiceDate(): ChoiceDate
    {
        return $this->firstChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getSecondChoiceDate(): ?ChoiceDate
    {
        return $this->secondChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getThirdChoiceDate(): ?ChoiceDate
    {
        return $this->thirdChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getFourthChoiceDate(): ?ChoiceDate
    {
        return $this->fourthChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getSubstitudeFirstChoiceDate(): ?ChoiceDate
    {
        return $this->substitudeFirstChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getSubstitudeSecondChoiceDate(): ?ChoiceDate
    {
        return $this->substitudeSecondChoiceDate;
    }

    /**
     * @return ChoiceDate|null
     */
    public function getSubstitudeThirdChoiceDate(): ?ChoiceDate
    {
        return $this->substitudeThirdChoiceDate;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return OrganizationId
     */
    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    /**
     * @return string|null
     */
    public function getNoReason(): ?string
    {
        return $this->noReason;
    }

    /**
     * @return TourStatus
     */
    public function getStatus(): TourStatus
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getUsePlansDate(): string
    {
        return $this->usePlansDate;
    }

    /**
     * @return int
     */
    public function getUsePlansPeople(): int
    {
        return $this->usePlansPeople;
    }

    /**
     * @return string
     */
    public function getUsePurpose(): string
    {
        return $this->usePurpose;
    }

    /**
     * @return string
     */
    public function getUsePurposeDetail(): string
    {
        return $this->usePurposeDetail;
    }

    /**
     * @return string
     */
    public function getChecklist(): string
    {
        return $this->checklist;
    }

    /**
     * @return DateTime|null
     */
    public function getEntryTime(): ?DateTime
    {
        return $this->entryTime;
    }

    /**
     * @return string|null
     */
    public function getFixChoiceDateColumnName(): ?string
    {
        return $this->fixChoiceDateColumnName;
    }

    /**
     * @return string|null
     */
    public function getFixChoiceTimeColumnName(): ?string
    {
        return $this->fixChoiceTimeColumnName;
    }

    /**
     * @return UserViewFlg
     */
    public function getUserViewFlg(): UserViewFlg
    {
        return $this->userViewFlg;
    }
}
