<?php

namespace App\Bundle\CustomerBundle\Application;

final class CustomerManageReceivingEmailPutCommand
{
    /**
     * @var int
     */
    public int $customerId;

    /**
     * @var bool
     */
    public bool $isReceivingReservationEmail;

    /**
     * @param int $customerId customerId
     * @param bool $isReceivingReservationEmail isReceivingReservationEmail
     */
    public function __construct(
        int $customerId,
        bool $isReceivingReservationEmail
    ) {
        $this->customerId = $customerId;
        $this->isReceivingReservationEmail = $isReceivingReservationEmail;
    }
}
