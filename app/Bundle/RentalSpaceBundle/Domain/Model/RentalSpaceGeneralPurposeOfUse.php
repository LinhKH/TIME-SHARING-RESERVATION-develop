<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceGeneralPurposeOfUse
{
    private string $mainCategory;
    private string $subCategory;
    private ?string $titleCategory;

    /**
     * @param string $mainCategory
     * @param string $subCategory
     * @param ?string $titleCategory
     */
    public function __construct(
        string $mainCategory,
        string $subCategory,
        ?string $titleCategory
    ) {
        $this->mainCategory = $mainCategory;
        $this->subCategory = $subCategory;
        $this->titleCategory = $titleCategory;
    }

    /**
     * @return string
     */
    public function getMainCategory(): string
    {
        return $this->mainCategory;
    }

    /**
     * @return string
     */
    public function getSubCategory(): string
    {
        return $this->subCategory;
    }

    /**
     * @return string
     */
    public function getTitleCategory(): ?string
    {
        return $this->titleCategory;
    }
}
