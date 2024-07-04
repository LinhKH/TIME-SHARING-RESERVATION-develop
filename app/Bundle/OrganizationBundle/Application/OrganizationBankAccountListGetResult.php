<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationBankAccountListGetResult
{
    public array $organizationBankAccount;

    /**
     * @param OrganizationBankAccountListResult[] $organizationBankAccount
     */
    public function __construct(
        array $organizationBankAccount

    ) {
        $this->organizationBankAccount = $organizationBankAccount;
    }
}
