<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceGetDetailPanoramaImageResult
{
    public array $imageFiles;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param RentalSpaceImageValueCommand[] $imageFiles
     */
    public function __construct(
        int $rentalSpaceId,
        array $imageFiles

    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->imageFiles = $imageFiles;
    }
}
