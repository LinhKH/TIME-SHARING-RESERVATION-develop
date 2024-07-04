<?php

namespace App\Bundle\CustomerBundle\Application;

use App\Bundle\Common\Application\PaginationResult;

final class CustomerManageListGetResult
{
    /**
     * @var \App\Bundle\CustomerBundle\Application\CustomerManageResult[]
     */
    public array $customerManageResults;

    /**
     * @var \App\Bundle\Common\Application\PaginationResult
     */
    public PaginationResult $paginationResult;

    /**
     * @param \App\Bundle\CustomerBundle\Application\CustomerManageResult[] $customerManageResults customerManageResults
     * @param \App\Bundle\Common\Application\PaginationResult $paginationResult paginationResult
     */
    public function __construct(
        array $customerManageResults,
        PaginationResult $paginationResult
    ) {
        $this->customerManageResults = $customerManageResults;
        $this->paginationResult = $paginationResult;
    }
}
