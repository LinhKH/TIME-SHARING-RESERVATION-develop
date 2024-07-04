<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceImageValue
{
    private int $height;
    private string $extension;
    private int $length;
    private int $width;
    private RentalSpaceImageType $type;
    private ?string $titleImage;
    private string $pathImage;
    private int $orderNumber;
    private string $imageId;

    public function __construct(
        string $imageId,
        string $pathImage,
        ?string $titleImage,
        RentalSpaceImageType $type,
        int $width,
        int $height,
        int $length,
        string $extension,
        int $orderNumber
    ){
        $this->imageId = $imageId;
        $this->pathImage = $pathImage;
        $this->titleImage = $titleImage;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->extension = $extension;
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getImageId(): string
    {
        return $this->imageId;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return RentalSpaceImageType
     */
    public function getType(): RentalSpaceImageType
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getTitleImage(): ?string
    {
        return $this->titleImage;
    }

    /**
     * @return string
     */
    public function getPathImage(): string
    {
        return $this->pathImage;
    }

    /**
     * @return int
     */
    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }
}
