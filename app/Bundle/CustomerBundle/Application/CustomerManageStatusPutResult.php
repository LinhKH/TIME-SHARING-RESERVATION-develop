<?php
namespace App\Bundle\CustomerBundle\Application;

final class CustomerManageStatusPutResult
{
    /**
     * @var int
     */
    public int $customerId;

    /**
     * @param int $customerId customerId
     */
    public function __construct(
        int $customerId
    ) {
        $this->customerId = $customerId;
    }
}
