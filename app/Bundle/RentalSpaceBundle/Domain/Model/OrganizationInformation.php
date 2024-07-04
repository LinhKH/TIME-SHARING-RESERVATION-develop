<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class OrganizationInformation
{

    private ?string $name;
    private ?string $nameFurigana;

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
}
