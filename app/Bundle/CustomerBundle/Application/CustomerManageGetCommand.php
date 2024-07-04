<?php

namespace App\Bundle\CustomerBundle\Application;

final class CustomerManageGetCommand
{
    /**
     * @var int
     */
    public int $customerId;

    /**
     * @noparam
     */
    public function __construct(int $customerId){
        $this->customerId = $customerId;
    }
}
