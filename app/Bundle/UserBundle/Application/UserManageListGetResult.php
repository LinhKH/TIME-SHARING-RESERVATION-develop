<?php
namespace App\Bundle\UserBundle\Application;

use \App\Bundle\Common\Application\PaginationResult;

final class UserManageListGetResult
{
    /**
     * @var \App\Bundle\UserBundle\Application\UserManageResult[]
     */
    public array $userManageResult;

    /**
     * @var \App\Bundle\Common\Application\PaginationResult
     */
    public PaginationResult $paginationResult;

    /**
     * @param \App\Bundle\UserBundle\Application\UserManageResult[] $userManageResult userManageResult
     * @param \App\Bundle\Common\Application\PaginationResult $paginationResult paginationResult
     */
    public function __construct(
        array $userManageResult,
        PaginationResult $paginationResult
    ) {
        $this->paginationResult = $paginationResult;
        $this->userManageResult = $userManageResult;
    }
}
