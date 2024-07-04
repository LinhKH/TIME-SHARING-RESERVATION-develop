<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceImage
{
    private RentalSpaceId $rentalSpaceId;
    private array $imageFiles;


    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceImageValue[] $imageFiles
     */

    public function __construct(
        RentalSpaceId $rentalSpaceId,
        array $imageFiles
    ) {
        $this->imageFiles = $imageFiles;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalSpaceImageValue[]
     */
    public function getImageFiles(): array
    {
        return $this->imageFiles;
    }

}
