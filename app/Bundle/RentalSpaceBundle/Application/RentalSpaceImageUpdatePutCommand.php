<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceImageUpdatePutCommand
{
    public int $rentalSpaceId;
    public string $imageId;
    public string $title;
    public string $imageType;

    /**
     * @param int $rentalSpaceId
     * @param string $imageId
     * @param string $imageType
     * @param string $title
     */
    public function __construct(
        int $rentalSpaceId,
        string $imageId,
        string $imageType,
        string $title
    ) {
        $this->imageType = $imageType;
        $this->title = $title;
        $this->imageId = $imageId;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
