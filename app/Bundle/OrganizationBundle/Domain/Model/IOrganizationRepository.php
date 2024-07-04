<?php

namespace App\Bundle\OrganizationBundle\Domain\Model;

interface  IOrganizationRepository
{
    /**
     * @param Organization $organization
     * @return OrganizationId
     */
    public function createOrganization(Organization $organization): OrganizationId;

    /**
     * @param OrganizationId $organizationId
     * @return Organization|null
     */
    public function findById(OrganizationId $organizationId): ?Organization;
}
