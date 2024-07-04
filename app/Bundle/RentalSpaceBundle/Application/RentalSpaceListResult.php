<?php
namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceListResult
{
    public int $id;
    public int $organizationId;
    public OrganizationInformationResult $organizationInformation;
    public string $status;
    public ?string $title;
    public string $draftStep;

    /**
     * @param int $id
     * @param int $organizationId
     * @param OrganizationInformationResult $organizationInformation
     * @param string $status
     * @param string|null $title
     * @param string $draftStep
     */
    public function __construct(
        int $id,
        int $organizationId,
        OrganizationInformationResult $organizationInformation,
        string $status,
        ?string $title,
        string $draftStep
    ) {
        $this->draftStep = $draftStep;
        $this->title = $title;
        $this->status = $status;
        $this->organizationInformation = $organizationInformation;
        $this->organizationId = $organizationId;
        $this->id = $id;
    }
}
