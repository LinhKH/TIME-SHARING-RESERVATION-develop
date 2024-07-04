<?php

namespace App\Bundle\OrganizationBundle\Infrastructure;

use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationBankAccountRepository;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationBankAccount;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Models\OrganizationBankAccount as ModelOrganizationBankAccount;

class OrganizationBankAccountRepository implements IOrganizationBankAccountRepository
{


    public function findAll(OrganizationId $organizationId): array
    {
        // TODO: Implement findAll() method.
        $entities = ModelOrganizationBankAccount::where('organization_id', $organizationId->getValue())->get()->toArray();
        if (empty($entities)){
            return [];
        }
        /** @var OrganizationBankAccount[] $result */
        $result = [];
        foreach ($entities as $entity) {

            $result[] = new OrganizationBankAccount(
                intval($entity['id']),
                $entity['account_number'],
                $entity['bank_code'],
                $entity['bank_name'],
                $entity['bank_name_katakana'],
                $entity['branch_code'],
                $entity['branch_name'],
                $entity['branch_name_katakana'],
                $entity['holder_name_katakana'],
                $entity['creation_time'],
                $entity['type']
            );
        }
        return $result;
    }
}
