<?php

namespace App\Bundle\CustomerBundle\Application;

final class CustomerManagePostCommand
{
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string|null
     */
    public ?string $customerType;
    /**
     * @var string|null
     */
    public ?string $genderType;
    /**
     * @var string|null
     */
    public ?string $firstName;
    /**
     * @var string|null
     */
    public ?string $lastName;
    /**
     * @var string|null
     */
    public ?string $firstNameKana;
    /**
     * @var string|null
     */
    public ?string $lastNameKana;
    /**
     * @var string|null
     */
    public ?string $phoneNumber;
    /**
     * @var string|null
     */
    public ?string $address;
    /**
     * @var string|null
     */
    public ?string $birthday;
    /**
     * @var string|null
     */
    public ?string $companyName;
    /**
     * @var string|null
     */
    public ?string $companyNameKana;
    /**
     * @var string|null
     */
    public ?string $localKey;
    /**
     * @var bool|null
     */
    public ?bool $isReceivingReservationEmails;
    /**
     * @var bool|null
     */
    public ?bool $isReceiveNewsletter;
    /**
     * @var string|null
     */
    public ?string $nickName;
    /**
     * @var string|null
     */
    public ?string $facebookUserId;
    /**
     * @var string
     */
    public string $password;

    /**
     * @param string $email email
     * @param string $password password
     * @param string|null $customerType customerType
     * @param string|null $genderType genderType
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $phoneNumber phoneNumber
     * @param string|null $address address
     * @param string|null $birthday birthday
     * @param string|null $companyName companyName
     * @param string|null $companyNameKana companyNameKana
     * @param string|null $localKey localKey
     * @param bool|null $isReceivingReservationEmails isReceivingReservationEmails
     * @param bool|null $isReceiveNewsletter isReceiveNewsletter
     * @param string|null $nickName nickName
     * @param string|null $facebookUserId facebookUserId
     */
    public function __construct(
        string $email,
        string $password,
        ?string $customerType = null,
        ?string $genderType = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $firstNameKana = null,
        ?string $lastNameKana = null,
        ?string $phoneNumber = null,
        ?string $address = null,
        ?string $birthday = null,
        ?string $companyName = null,
        ?string $companyNameKana = null,
        ?string $localKey = null,
        ?bool $isReceivingReservationEmails = null,
        ?bool $isReceiveNewsletter = null,
        ?string $nickName = null,
        ?string $facebookUserId = null
    ) {
        $this->email = $email;
        $this->customerType = $customerType;
        $this->genderType = $genderType;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->birthday = $birthday;
        $this->companyName = $companyName;
        $this->companyNameKana = $companyNameKana;
        $this->localKey = $localKey;
        $this->isReceivingReservationEmails = $isReceivingReservationEmails;
        $this->isReceiveNewsletter = $isReceiveNewsletter;
        $this->nickName = $nickName;
        $this->facebookUserId = $facebookUserId;
        $this->password = $password;
    }
}
