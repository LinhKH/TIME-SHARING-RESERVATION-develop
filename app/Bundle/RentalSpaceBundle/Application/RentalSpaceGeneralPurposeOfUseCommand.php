<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGeneralPurposeOfUseCommand
{
    public string $mainCategory;
    public string $subCategory;
    public ?string $titleCategory;

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
}
