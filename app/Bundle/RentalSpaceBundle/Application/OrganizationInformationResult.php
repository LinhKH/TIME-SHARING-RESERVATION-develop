<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class OrganizationInformationResult
{
    public ?string $name;
    public ?string $nameFurigana;

    /**
     * @param string|null $name
     * @param string|null $nameFurigana
     */
    public function __construct(
        ?string $name,
        ?string $nameFurigana
    ){
        $this->name = $name;
        $this->nameFurigana = $nameFurigana;
    }
}
