<?php

namespace App\Bundle\CustomerBundle\Application;

use \App\Bundle\Common\Application\PaginationResult;

final class CustomerManageResult
{
    /**
     * @var int
     */
    public int $customerId;
    /**
     * @var int
     */
    public int $isActive;
    /**
     * @var string
     */
    public string $customerType;
    /**
     * @var string
     */
    public string $genderType;
    /**
     * @var int
     */
    public int $creationTime;
    /**
     * @var string|null
     */
    public ?string $email;
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
     * @var int|null
     */
    public ?int $birthday;
    /**
     * @var int|null
     */
    public ?int $numberOfReviews;
    /**
     * @var int|null
     */
    public ?int $totalPriceSansTax;

    /**
     * @param int $customerId customerId
     * @param int $isActive isActive
     * @param string $customerType customerType
     * @param string $genderType genderType
     * @param int $creationTime creationTime
     * @param string|null $email email
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $phoneNumber phoneNumber
     * @param string|null $address address
     * @param int|null $birthday birthday
     * @param int|null $numberOfReviews numberOfReviews
     * @param int|null $totalPriceSansTax totalPriceSansTax
     */
    public function __construct(
        int $customerId,
        int $isActive,
        string $customerType,
        string $genderType,
        int $creationTime,
        ?string $email,
        ?string $firstName,
        ?string $lastName,
        ?string $firstNameKana,
        ?string $lastNameKana,
        ?string $phoneNumber,
        ?string $address,
        ?int $birthday,
        ?int $numberOfReviews,
        ?int $totalPriceSansTax
    ) {
        $this->customerId = $customerId;
        $this->isActive = $isActive;
        $this->customerType = $customerType;
        $this->genderType = $genderType;
        $this->creationTime = $creationTime;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->birthday = $birthday;
        $this->numberOfReviews = $numberOfReviews;
        $this->totalPriceSansTax = $totalPriceSansTax;
    }
}
