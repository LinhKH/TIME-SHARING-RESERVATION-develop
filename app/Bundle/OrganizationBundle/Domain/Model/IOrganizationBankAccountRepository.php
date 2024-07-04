<?php

namespace App\Bundle\OrganizationBundle\Domain\Model;

interface IOrganizationBankAccountRepository
{
    /**
     * @param OrganizationId $organizationId
     * @return OrganizationBankAccount[]
     */
    public function findAll(OrganizationId $organizationId): array;
}
