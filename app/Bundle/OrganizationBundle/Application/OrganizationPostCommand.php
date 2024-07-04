<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationPostCommand {
    public ?string $name;
    public ?string $nameFurigana;
    public ?string $note;
    public int $active;

    /**
     * @param string|null $name name
     * @param string|null $nameFurigana nameFurigana
     * @param string|null $note note
     * @param int $active
     */
    public function __construct(
        ?string $name,
        ?string $nameFurigana,
        ?string $note,
        int $active
    ) {
        $this->name = $name;
        $this->nameFurigana = $nameFurigana;
        $this->note = $note;
        $this->active = $active;
    }
}
