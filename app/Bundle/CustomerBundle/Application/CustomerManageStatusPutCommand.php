<?php

namespace App\Bundle\CustomerBundle\Application;

final class CustomerManageStatusPutCommand
{
    /**
     * @var int
     */
    public int $customerId;

    /**
     * @var bool
     */
    public bool $isActive;

    /**
     * @param int $customerId customerId
     * @param bool $isActive isActive
     */
    public function __construct(
        int $customerId,
        bool $isActive
    ) {
        $this->customerId = $customerId;
        $this->isActive = $isActive;
    }
}
