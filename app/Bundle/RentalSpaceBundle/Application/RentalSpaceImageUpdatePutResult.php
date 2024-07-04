<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceImageUpdatePutResult
{
    public ?string $imageId;

    /**
     * @param string|null $imageId
     */
    public function __construct(
        ?string $imageId
    ) {
        $this->imageId = $imageId;
    }
}
