<?php
namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\UserBundle\Domain\Model\OrganizationId;

final class Organization {
    private ?OrganizationId $organizationId;
    private ?string $name;
    private ?string $nameFurigana;
    private ?string $note;
    private int $active;

    /**
     * @param OrganizationId|null $organizationId
     * @param string|null $name
     * @param string|null $nameFurigana
     * @param string|null $note
     * @param int $active
     */
    public function __construct(
        ?OrganizationId $organizationId,
        ?string $name,
        ?string $nameFurigana,
        ?string $note,
        int $active
    ) {
        $this->organizationId = $organizationId;
        $this->name = $name;
        $this->nameFurigana = $nameFurigana;
        $this->note = $note;
        $this->active = $active;
    }

    /**
     * @return OrganizationId|null
     */
    public function getOrganizationId(): ?OrganizationId
    {
        return $this->organizationId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNameFurigana(): ?string
    {
        return $this->nameFurigana;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }
}
