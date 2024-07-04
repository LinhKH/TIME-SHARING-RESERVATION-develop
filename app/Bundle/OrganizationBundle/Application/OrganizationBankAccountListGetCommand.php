<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationBankAccountListGetCommand
{
    /**
     * @var int
     */
    public int $organizationId;


    /**
     * OrganizationGetCommand constructor.
     * @param int $organizationId
     */
    public function __construct(int $organizationId)
    {
        $this->organizationId = $organizationId;
    }
}
