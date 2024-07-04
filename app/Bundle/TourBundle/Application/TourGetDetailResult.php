<?php

namespace App\Bundle\TourBundle\Application;

final class TourGetDetailResult
{
    public int $tourId;
    public string $rentalSpaceName;
    public int $userId;
    public int $rentalSpaceId;
    public int $organizationId;
    public string $checkList;
    public string $entryTime;
    public string $firstChoiceDate;
    public string $firstChoiceTime;
    public ?string $secondChoiceDate;
    public ?string $secondChoiceTime;
    public ?string $thirdChoiceDate;
    public ?string $thirdChoiceTime;
    public ?string $fourthChoiceDate;
    public ?string $fourthChoiceTime;
    public ?string $substitudeFirstChoiceDate;
    public ?string $substitudeFirstChoiceTime;
    public ?string $substitudeSecondChoiceDate;
    public ?string $substitudeSecondChoiceTime;
    public ?string $substitudeThirdChoiceDate;
    public ?string $substitudeThirdChoiceTime;
    public string $status;
    public ?string $fixChoiceDateColumnDate;
    public ?string $fixChoiceDateColumnTime;
    public ?int $noReason;
    public string $usePlansDate;
    public int $usePlansPeople;
    public string $usePurpose;
    public string $usePurposeDetail;
    public int $userViewFlg;
    public int $customerType;
    public int $gender;
    public ?string $companyName;
    public ?string $companyNameKana;
    public ?string $customerName;
    public ?string $birthday;
    public ?string $phone;
    public ?string $customerEmail;
    public ?string $customerAddress;
    public string $customerRegistrationDate;
    public ?string $customerId;

    /**
     * TourGetDetailResult constructor.
     * @param int $tourId
     * @param string $rentalSpaceName
     * @param int $userId
     * @param int $rentalSpaceId
     * @param int $organizationId
     * @param string $checkList
     * @param string $entryTime
     * @param string $firstChoiceDate
     * @param string $firstChoiceTime
     * @param string|null $secondChoiceDate
     * @param string|null $secondChoiceTime
     * @param string|null $thirdChoiceDate
     * @param string|null $thirdChoiceTime
     * @param string|null $fourthChoiceDate
     * @param string|null $fourthChoiceTime
     * @param string|null $substitudeFirstChoiceDate
     * @param string|null $substitudeFirstChoiceTime
     * @param string|null $substitudeSecondChoiceDate
     * @param string|null $substitudeSecondChoiceTime
     * @param string|null $substitudeThirdChoiceDate
     * @param string|null $substitudeThirdChoiceTime
     * @param int $status
     * @param string|null $fixChoiceDateColumnDate
     * @param string|null $fixChoiceDateColumnTime
     * @param int|null $noReason
     * @param string $usePlansDate
     * @param string $usePlansPeople
     * @param string $usePurpose
     * @param string $usePurposeDetail
     * @param string $userViewFlg
     * @param int $customerType
     * @param int $gender
     * @param string|null $companyName
     * @param string|null $companyNameKana
     * @param string|null $customerName
     * @param string|null $birthday
     * @param string|null $phone
     * @param string|null $customerEmail
     * @param string|null $customerAddress
     * @param string $customerRegistrationDate
     * @param string|null $customerId
     */
    public function __construct(
        int $tourId,
        string  $rentalSpaceName,
        int $userId,
        int $rentalSpaceId,
        int $organizationId,
        string $checkList,
        string $entryTime,
        string $firstChoiceDate,
        string $firstChoiceTime,
        ?string $secondChoiceDate,
        ?string $secondChoiceTime,
        ?string $thirdChoiceDate,
        ?string $thirdChoiceTime,
        ?string $fourthChoiceDate,
        ?string $fourthChoiceTime,
        ?string $substitudeFirstChoiceDate,
        ?string $substitudeFirstChoiceTime,
        ?string $substitudeSecondChoiceDate,
        ?string $substitudeSecondChoiceTime,
        ?string $substitudeThirdChoiceDate,
        ?string $substitudeThirdChoiceTime,
        string $status,
        ?string $fixChoiceDateColumnDate,
        ?string $fixChoiceDateColumnTime,
        ?int $noReason,
        string $usePlansDate,
        string $usePlansPeople,
        string $usePurpose,
        string $usePurposeDetail,
        string $userViewFlg,
        int $customerType,
        int $gender,
        ?string $companyName,
        ?string $companyNameKana,
        ?string $customerName,
        ?string $birthday,
        ?string $phone,
        ?string $customerEmail,
        ?string $customerAddress,
        string $customerRegistrationDate,
        ?string $customerId

    ) {
        $this->tourId = $tourId;
        $this->rentalSpaceName = $rentalSpaceName;
        $this->userId = $userId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->organizationId = $organizationId;;
        $this->checkList = $checkList;
        $this->entryTime = $entryTime;
        $this->firstChoiceDate = $firstChoiceDate;
        $this->firstChoiceTime = $firstChoiceTime;
        $this->secondChoiceDate = $secondChoiceDate;
        $this->secondChoiceTime = $secondChoiceTime;
        $this->thirdChoiceDate = $thirdChoiceDate;
        $this->thirdChoiceTime = $thirdChoiceTime;
        $this->fourthChoiceDate = $fourthChoiceDate;
        $this->fourthChoiceTime = $fourthChoiceTime;
        $this->substitudeFirstChoiceDate = $substitudeFirstChoiceDate;
        $this->substitudeFirstChoiceTime = $substitudeFirstChoiceTime;
        $this->substitudeSecondChoiceDate = $substitudeSecondChoiceDate;
        $this->substitudeSecondChoiceTime = $substitudeSecondChoiceTime;
        $this->substitudeThirdChoiceDate = $substitudeThirdChoiceDate;
        $this->substitudeThirdChoiceTime = $substitudeThirdChoiceTime;
        $this->status = $status;
        $this->fixChoiceDateColumnDate = $fixChoiceDateColumnDate;
        $this->fixChoiceDateColumnTime = $fixChoiceDateColumnTime;
        $this->noReason = $noReason;
        $this->usePlansDate = $usePlansDate;
        $this->usePlansPeople = $usePlansPeople;
        $this->usePurpose = $usePurpose;
        $this->usePurposeDetail = $usePurposeDetail;
        $this->userViewFlg = $userViewFlg;
        $this->customerType = $customerType;
        $this->gender = $gender;
        $this->companyName = $companyName;
        $this->companyNameKana = $companyNameKana;
        $this->customerName = $customerName;
        $this->birthday = $birthday;
        $this->phone = $phone;
        $this->customerEmail = $customerEmail;
        $this->customerAddress = $customerAddress;
        $this->customerRegistrationDate = $customerRegistrationDate;
        $this->customerId = $customerId;
    }
}
