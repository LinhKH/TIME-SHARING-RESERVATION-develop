<?php

namespace App\Bundle\OrganizationBundle\Application;

use App\Bundle\OrganizationBundle\Application\CompanyInformationResult;

final class OrganizationResult
{
    /**
     * @var int
     */
    public int $organizationId;

    /**
     * @var string
     */
    public string $organizationInformation;

    /**
     * @var string
     */
    public string $note;

    /**
     * @var int
     */
    public int $active;

    /**
     * @param int $id
     * @param OrganizationResult $organizationInformation
     * @param string $note
     * @param int $active
     */
    public function __construct(
        int $id,
        string $organizationInformation,
        string $note,
        int $active
    ) {
        $this->id = $id;
        $this->organizationInformation = $organizationInformation;
        $this->note = $note;
        $this->active = $active;
    }

}
