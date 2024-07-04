<?php
namespace App\Bundle\UserBundle\Domain\Model;

interface IOrganizationRepository
{
    /**
     * @param \App\Bundle\UserBundle\Domain\Model\OrganizationId $organizationId organizationId
     * @return \App\Bundle\UserBundle\Domain\Model\Organization
     */
    public function findById(OrganizationId $organizationId): Organization;
}
