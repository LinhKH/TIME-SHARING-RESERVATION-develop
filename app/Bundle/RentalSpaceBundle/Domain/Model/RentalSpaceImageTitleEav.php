<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceImageTitleEav
{
    private RentalSpaceId $rentalSpaceId;
    private RentalSpaceImageId $imageId;
    private string $title;
    private RentalSpaceImageType $imageType;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceImageId $imageId
     * @param RentalSpaceImageType $imageType
     * @param string $title
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        RentalSpaceImageId $imageId,
        RentalSpaceImageType $imageType,
        string $title
    ) {
        $this->imageType = $imageType;
        $this->title = $title;
        $this->imageId = $imageId;
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
     * @return RentalSpaceImageId
     */
    public function getImageId(): RentalSpaceImageId
    {
        return $this->imageId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return RentalSpaceImageType
     */
    public function getImageType(): RentalSpaceImageType
    {
        return $this->imageType;
    }
}
