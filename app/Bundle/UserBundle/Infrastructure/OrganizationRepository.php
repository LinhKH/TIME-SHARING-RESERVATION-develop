<?php
namespace App\Bundle\UserBundle\Infrastructure;

use App\Bundle\UserBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\UserBundle\Domain\Model\Organization;
use App\Bundle\UserBundle\Domain\Model\OrganizationId;
use App\Models\Organization as OrganizationModel;

class OrganizationRepository implements IOrganizationRepository
{
    /**
     * @inheritDoc
     */
    public function findById(OrganizationId $organizationId): Organization
    {
        $result = OrganizationModel::find($organizationId->getValue());

        $organizationInfo = json_decode($result->company_information, true);

        return new Organization(
            new OrganizationId($result->id),
            $organizationInfo['name'],
            $organizationInfo['name_furigana'],
            $result->note,
            $result->active
        );
    }
}
