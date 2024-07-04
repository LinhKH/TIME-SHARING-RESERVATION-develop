<?php

namespace App\Bundle\CustomerBundle\Domain\Model;

final class CustomerFilter
{
    /**
     * @var string|null
     */
    private ?string $created_at;

    /**
     * @var string|null
     */
    private ?string $total_fee;

    /**
     * @var string|null
     */
    private ?string $number_of_reviews;

    /**
     * @var string|null
     */
    private ?string $firstName;

    /**
     * @var string|null
     */
    private ?string $email;

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
    private ?array $membership_type;
    /**
     * @var string|null
     */
    private ?string $emailStatus;
    /**
     * @var string|null
     */
    private ?string $phoneNumberStatus;

    /**
     * @var int|null
     */
    private ?int $e_mail_magazine;
    /**
     * @var int|null
     */
    private ?int $status;

    /**
     * @var string|null
     */
    private ?string $registrationDateStart;
    /**
     * @var string|null
     */
    private ?string $registrationDateEnd;

    public function __construct(
        ?string $created_at,
        ?string $total_fee,
        ?string $number_of_reviews,
        ?string $firstName,
        ?string $email,
        ?string $address,
        ?array $membership_type,
        ?string $phoneNumber,
        ?string $emailStatus,
        ?string $phoneNumberStatus,
        ?int $e_mail_magazine,
        ?int $status,
        ?string $registrationDateStart,
        ?string $registrationDateEnd
    ) {
        $this->created_at = $created_at;
        $this->total_fee = $total_fee;
        $this->number_of_reviews = $number_of_reviews;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->address = $address;
        $this->membership_type = $membership_type;
        $this->phoneNumber = $phoneNumber;
        $this->emailStatus = $emailStatus;
        $this->phoneNumberStatus = $phoneNumberStatus;
        $this->e_mail_magazine = $e_mail_magazine;
        $this->status = $status;
        $this->registrationDateStart = $registrationDateStart;
        $this->registrationDateEnd = $registrationDateEnd;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string|null $created_at
     */
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string|null
     */
    public function getTotalFee(): ?string
    {
        return $this->total_fee;
    }

    /**
     * @param string|null $total_fee
     */
    public function setTotalFee(?string $total_fee): void
    {
        $this->total_fee = $total_fee;
    }

    /**
     * @return string|null
     */
    public function getNumberOfReviews(): ?string
    {
        return $this->number_of_reviews;
    }

    /**
     * @param string|null $number_of_reviews
     */
    public function setNumberOfReviews(?string $number_of_reviews): void
    {
        $this->number_of_reviews = $number_of_reviews;
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
     * @return array|null
     */
    public function getMembershipType(): ?array
    {
        return $this->membership_type;
    }

    /**
     * @param array|null $membership_type
     */
    public function setMembershipType(?array $membership_type): void
    {
        $this->membership_type = $membership_type;
    }

    /**
     * @return string|null
     */
    public function getEmailStatus(): ?string
    {
        return $this->emailStatus;
    }

    /**
     * @param string|null $emailStatus
     */
    public function setEmailStatus(?string $emailStatus): void
    {
        $this->emailStatus = $emailStatus;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumberStatus(): ?string
    {
        return $this->phoneNumberStatus;
    }

    /**
     * @param string|null $phoneNumberStatus
     */
    public function setPhoneNumberStatus(?string $phoneNumberStatus): void
    {
        $this->phoneNumberStatus = $phoneNumberStatus;
    }

    /**
     * @return int|null
     */
    public function getEMailMagazine(): ?int
    {
        return $this->e_mail_magazine;
    }

    /**
     * @param int|null $e_mail_magazine
     */
    public function setEMailMagazine(?int $e_mail_magazine): void
    {
        $this->e_mail_magazine = $e_mail_magazine;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getRegistrationDateStart(): ?string
    {
        return $this->registrationDateStart;
    }

    /**
     * @param string|null $registrationDateStart
     */
    public function setRegistrationDateStart(?string $registrationDateStart): void
    {
        $this->registrationDateStart = $registrationDateStart;
    }

    /**
     * @return string|null
     */
    public function getRegistrationDateEnd(): ?string
    {
        return $this->registrationDateEnd;
    }

    /**
     * @param string|null $registrationDateEnd
     */
    public function setRegistrationDateEnd(?string $registrationDateEnd): void
    {
        $this->registrationDateEnd = $registrationDateEnd;
    }
}
