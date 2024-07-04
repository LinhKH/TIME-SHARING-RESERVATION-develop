<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationPostResult
{
    public int $organizationId;
    /**
     * @param int $organizationId organizationId
     */
    public function __construct(
        int $organizationId
    ) {
        $this->organizationId = $organizationId;
    }
}
