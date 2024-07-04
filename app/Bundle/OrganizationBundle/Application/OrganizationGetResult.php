<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationGetResult
{
    /**
     * @var int
     */
    public int $organizationId;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $nameFurigana;

    /**
     * @var string|null
     */
    public ?string $note;

    /**
     * @var int
     */
    public int $active;

    public function __construct(
        int $organizationId,
        ?string $name,
        ?string $nameFurigana,
        ?string $note,
        int $active
    )
    {
        $this->organizationId = $organizationId;
        $this->name = $name;
        $this->nameFurigana = $nameFurigana;
        $this->note = $note;
        $this->active = $active;
    }
}
