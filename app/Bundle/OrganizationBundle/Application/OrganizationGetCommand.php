<?php

namespace App\Bundle\OrganizationBundle\Application;

use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;

final class OrganizationGetCommand
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
