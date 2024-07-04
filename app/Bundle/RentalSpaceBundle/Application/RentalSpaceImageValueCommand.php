<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceImageValueCommand
{
    public int $height;
    public string $extension;
    public int $length;
    public int $width;
    public string $type;
    public ?string $titleImage;
    public string $pathImage;
    public int $orderNumber;
    public string $imageId;

    /**
     * @param string $imageId
     * @param string $pathImage
     * @param string|null $titleImage
     * @param string $type
     * @param int $width
     * @param int $height
     * @param int $length
     * @param string $extension
     * @param int $orderNumber
     */
    public function __construct(
        string $imageId,
        string $pathImage,
        ?string $titleImage,
        string $type,
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

}
