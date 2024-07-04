<?php

namespace App\Bundle\CustomerBundle\Application;

final class CustomerManageListGetCommand
{
    public ?string $created_at;
    public ?string $total_fee;
    public ?string $number_of_reviews;
    public ?string $firstName;
    public ?string $email;
    public ?string $address;
    public ?array $membership_type;
    public ?string $phoneNumber;
    public ?string $emailStatus;
    public ?string $phoneNumberStatus;
    public ?int $e_mail_magazine;
    public ?int $status;
    public ?string $registrationDateStart;
    public ?string $registrationDateEnd;

    /**
     * @noparam
     */
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
}
