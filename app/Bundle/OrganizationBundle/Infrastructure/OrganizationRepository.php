<?php

namespace App\Bundle\OrganizationBundle\Infrastructure;

use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\OrganizationBundle\Domain\Model\Organization;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Models\Organization as OrganizationModel;

class OrganizationRepository implements IOrganizationRepository
{
    /**
     * @inheritDoc
     */
    public function createOrganization(Organization $organization): OrganizationId
    {
        $result = OrganizationModel::create([
            'company_information' => json_encode([
                'name' => $organization->getName(),
                'name_furigana' => $organization->getNameFurigana(),
            ]),
            'creation_time' => time(),
            'note' => $organization->getNote(),
            'active' => $organization->getActive()
        ]);

        return new OrganizationId($result->id);
    }


    /**
     * @inheritDoc
     */
    public function findById(OrganizationId $organizationId): ?Organization
    {
        $entity = OrganizationModel::find($organizationId->getValue());
        if (!$entity) {
            return null;
        }

        $companyInformation = json_decode($entity->company_information);

        return new Organization(
            new OrganizationId($entity->id),
            $companyInformation->name,
            $companyInformation->name_furigana,
            $entity->note,
            $entity->active
        );
    }
}
