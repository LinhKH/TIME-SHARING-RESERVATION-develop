<?php

namespace App\Bundle\CustomerBundle\Domain\Model;

final class Customer {
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\CustomerId|null
     */
    private ?CustomerId $customerId;
    /**
     * @var int
     */
    private int $isActive;
    /**
     * @var string|null
     */
    private ?string $nickName;
    /**
     * @var string|null
     */
    private ?string $firstName;
    /**
     * @var string|null
     */
    private ?string $lastName;
    /**
     * @var string|null
     */
    private ?string $firstNameKana;
    /**
     * @var string|null
     */
    private ?string $lastNameKana;
    /**
     * @var string|null
     */
    private ?string $companyName;
    /**
     * @var string|null
     */
    private ?string $companyNameKana;
    /**
     * @var string|null
     */
    private ?string $email;
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\CustomerType
     */
    private CustomerType $customerType;
    /**
     * @var string|null
     */
    private ?string $facebookUserId;
    /**
     * @var string|null
     */
    private ?string $password;
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\SettingTime|null
     */
    private ?SettingTime $birthday;
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\GenderType
     */
    private GenderType $genderType;
    /**
     * @var string|null
     */
    private ?string $phoneNumber;
    /**
     * @var string|null
     */
    private ?string $address;
    /**
     * @var string|null
     */
    private ?string $loginEmail;
    /**
     * @var string|null
     */
    private ?string $cardHolderFirstName;
    /**
     * @var string|null
     */
    private ?string $cardHolderLastName;
    /**
     * @var string|null
     */
    private ?string $cardType;
    /**
     * @var string|null
     */
    private ?string $cardReference;
    /**
     * @var string|null
     */
    private ?string $localKey;
    /**
     * @var string|null
     */
    private ?string $confirmationToken;
    /**
     * @var string|null
     */
    private ?string $recoveryToken;
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\SettingTime
     */
    private SettingTime $creationTime;
    /**
     * @var string|null
     */
    private ?string $nextUrl;
    /**
     * @var bool
     */
    private bool $receivingReservationEmails;
    /**
     * @var bool
     */
    private bool $newsletterSubscribed;
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\BusinessStructureType|null
     */
    private ?BusinessStructureType $businessStructure;
    /**
     * @var int|null
     */
    private ?int $numberOfReviews;
    /**
     * @var int|null
     */
    private ?int $totalPriceSansTax;

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\CustomerId|null $customerId customerId
     * @param int $isActive isActive
     * @param \App\Bundle\CustomerBundle\Domain\Model\CustomerType $customerType customerType
     * @param \App\Bundle\CustomerBundle\Domain\Model\GenderType $genderType genderType
     * @param \App\Bundle\CustomerBundle\Domain\Model\SettingTime $creationTime creationTime
     * @param bool $receivingReservationEmails receivingReservationEmails
     * @param bool $newsletterSubscribed newsletterSubscribed
     * @param string|null $localKey localKey
     * @param string|null $email email
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $phoneNumber phoneNumber
     * @param string|null $address address
     * @param SettingTime|null $birthday $birthday
     */
    public function __construct(
        ?CustomerId $customerId,
        int $isActive,
        CustomerType $customerType,
        GenderType $genderType,
        SettingTime $creationTime,
        bool $receivingReservationEmails,
        bool $newsletterSubscribed,
        ?string $localKey,
        ?string $email = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $firstNameKana = null,
        ?string $lastNameKana = null,
        ?string $phoneNumber = null,
        ?string $address = null,
        ?SettingTime $birthday = null
    ) {
        $this->customerId = $customerId;
        $this->isActive = $isActive;
        $this->customerType = $customerType;
        $this->genderType = $genderType;
        $this->creationTime = $creationTime;
        $this->receivingReservationEmails = $receivingReservationEmails;
        $this->newsletterSubscribed = $newsletterSubscribed;
        $this->localKey = $localKey;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->birthday = $birthday;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\CustomerId|null
     */
    public function getCustomerId(): ?CustomerId
    {
        return $this->customerId;
    }

    /**
     * @return int
     */
    public function isActive(): int
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    /**
     * @param string|null $nickName
     */
    public function setNickName(?string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getFirstNameKana(): ?string
    {
        return $this->firstNameKana;
    }

    /**
     * @param string|null $firstNameKana
     */
    public function setFirstNameKana(?string $firstNameKana): void
    {
        $this->firstNameKana = $firstNameKana;
    }

    /**
     * @return string|null
     */
    public function getLastNameKana(): ?string
    {
        return $this->lastNameKana;
    }

    /**
     * @param string|null $lastNameKana
     */
    public function setLastNameKana(?string $lastNameKana): void
    {
        $this->lastNameKana = $lastNameKana;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string|null
     */
    public function getCompanyNameKana(): ?string
    {
        return $this->companyNameKana;
    }

    /**
     * @param string|null $companyNameKana
     */
    public function setCompanyNameKana(?string $companyNameKana): void
    {
        $this->companyNameKana = $companyNameKana;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\CustomerType
     */
    public function getCustomerType(): CustomerType
    {
        return $this->customerType;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\CustomerType $customerType customerType
     */
    public function setCustomerType(CustomerType $customerType): void
    {
        $this->customerType = $customerType;
    }

    /**
     * @return string|null
     */
    public function getFacebookUserId(): ?string
    {
        return $this->facebookUserId;
    }

    /**
     * @param string|null $facebookUserId
     */
    public function setFacebookUserId(?string $facebookUserId): void
    {
        $this->facebookUserId = $facebookUserId;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\SettingTime|null
     */
    public function getBirthday(): ?SettingTime
    {
        return $this->birthday;
    }

    /**
     * @param int|null $birthday
     */
    public function setBirthday(?int $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\GenderType
     */
    public function getGenderType(): GenderType
    {
        return $this->genderType;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\GenderType $genderType genderType
     */
    public function setGenderType(GenderType $genderType): void
    {
        $this->genderType = $genderType;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getLoginEmail(): ?string
    {
        return $this->loginEmail;
    }

    /**
     * @param string|null $loginEmail
     */
    public function setLoginEmail(?string $loginEmail): void
    {
        $this->loginEmail = $loginEmail;
    }

    /**
     * @return string|null
     */
    public function getCardHolderFirstName(): ?string
    {
        return $this->cardHolderFirstName;
    }

    /**
     * @param string|null $cardHolderFirstName
     */
    public function setCardHolderFirstName(?string $cardHolderFirstName): void
    {
        $this->cardHolderFirstName = $cardHolderFirstName;
    }

    /**
     * @return string|null
     */
    public function getCardHolderLastName(): ?string
    {
        return $this->cardHolderLastName;
    }

    /**
     * @param string|null $cardHolderLastName
     */
    public function setCardHolderLastName(?string $cardHolderLastName): void
    {
        $this->cardHolderLastName = $cardHolderLastName;
    }

    /**
     * @return string|null
     */
    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    /**
     * @param string|null $cardType
     */
    public function setCardType(?string $cardType): void
    {
        $this->cardType = $cardType;
    }

    /**
     * @return string|null
     */
    public function getCardReference(): ?string
    {
        return $this->cardReference;
    }

    /**
     * @param string|null $cardReference
     */
    public function setCardReference(?string $cardReference): void
    {
        $this->cardReference = $cardReference;
    }

    /**
     * @return string
     */
    public function getLocalKey(): string
    {
        return $this->localKey;
    }

    /**
     * @param string $localKey
     */
    public function setLocalKey(string $localKey): void
    {
        $this->localKey = $localKey;
    }

    /**
     * @return string|null
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    /**
     * @param string|null $confirmationToken
     */
    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return string|null
     */
    public function getRecoveryToken(): ?string
    {
        return $this->recoveryToken;
    }

    /**
     * @param string|null $recoveryToken
     */
    public function setRecoveryToken(?string $recoveryToken): void
    {
        $this->recoveryToken = $recoveryToken;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\SettingTime
     */
    public function getCreationTime(): SettingTime
    {
        return $this->creationTime;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\SettingTime $creationTime
     */
    public function setCreationTime(SettingTime $creationTime): void
    {
        $this->creationTime = $creationTime;
    }

    /**
     * @return string|null
     */
    public function getNextUrl(): ?string
    {
        return $this->nextUrl;
    }

    /**
     * @param string|null $nextUrl
     */
    public function setNextUrl(?string $nextUrl): void
    {
        $this->nextUrl = $nextUrl;
    }

    /**
     * @return bool
     */
    public function isReceivingReservationEmails(): bool
    {
        return $this->receivingReservationEmails;
    }

    /**
     * @param bool $receivingReservationEmails
     */
    public function setReceivingReservationEmails(bool $receivingReservationEmails): void
    {
        $this->receivingReservationEmails = $receivingReservationEmails;
    }

    /**
     * @return bool
     */
    public function isNewsletterSubscribed(): bool
    {
        return $this->newsletterSubscribed;
    }

    /**
     * @param bool $newsletterSubscribed
     */
    public function setNewsletterSubscribed(bool $newsletterSubscribed): void
    {
        $this->newsletterSubscribed = $newsletterSubscribed;
    }

    /**
     * @return \App\Bundle\CustomerBundle\Domain\Model\BusinessStructureType|null
     */
    public function getBusinessStructure(): ?BusinessStructureType
    {
        return $this->businessStructure;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\BusinessStructureType|null $businessStructure businessStructure
     */
    public function setBusinessStructure(?BusinessStructureType $businessStructure): void
    {
        $this->businessStructure = $businessStructure;
    }

    /**
     * @return int|null
     */
    public function getNumberOfReviews(): ?int
    {
        return $this->numberOfReviews;
    }

    /**
     * @param int|null $numberOfReviews
     */
    public function setNumberOfReviews(?int $numberOfReviews): void
    {
        $this->numberOfReviews = $numberOfReviews;
    }

    /**
     * @return int|null
     */
    public function getTotalPriceSansTax(): ?int
    {
        return $this->totalPriceSansTax;
    }

    /**
     * @param int|null $total
     */
    public function setTotalPriceSansTax(?int $total): void
    {
        $this->totalPriceSansTax = $total;
    }

    /**
     * @return string
     */
    public function getFullName(): string {
        $fullName = $this->lastName . ' ' . $this->firstName;
        return trim($fullName);
    }
}
