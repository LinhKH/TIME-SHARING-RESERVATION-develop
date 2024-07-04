<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

class RentalSpaceCollection
{
    private ?RentalSpaceId $rentalSpaceId;
    private OrganizationId $organizationId;
    private ?OrganizationInformation $organizationInformation;
    private string $status;
    private ?string $title;
    private string $draftStep;
    private ?int $tourFlg;

    /**
     * @param RentalSpaceId|null $rentalSpaceId
     * @param OrganizationId $organizationId
     * @param OrganizationInformation|null $organizationInformation
     * @param string $status
     * @param string|null $title
     * @param string $draftStep
     * @param int|null $tourFlg
     */
    public function __construct(
        ?RentalSpaceId $rentalSpaceId,
        OrganizationId $organizationId,
        ?OrganizationInformation $organizationInformation,
        string $status,
        ?string $title,
        string $draftStep,
        ?int $tourFlg
    )
    {
        $this->draftStep = $draftStep;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->organizationId = $organizationId;
        $this->organizationInformation = $organizationInformation;
        $this->status = $status;
        $this->title = $title;
        $this->tourFlg = $tourFlg;
    }

    /**
     * @return string
     */
    public function getDraftStep(): string
    {
        return $this->draftStep;
    }

    /**
     * @return RentalSpaceId|null
     */
    public function getRentalSpaceId(): ?RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return OrganizationId
     */
    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return OrganizationInformation|null
     */
    public function getOrganizationInformation(): OrganizationInformation
    {
        return $this->organizationInformation;
    }

    /**
     * @return int|null
     */
    public function getTourFlg(): ?int
    {
        return $this->tourFlg;
    }
}
