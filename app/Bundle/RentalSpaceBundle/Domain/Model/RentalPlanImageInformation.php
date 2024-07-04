<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalPlanImageInformation
{
    private string $extension;
    private string $length;
    private string $width;
    private string $height;
    private string $s3key;
    private string $imageId;

    /**
     * @param string $imageId
     * @param string $s3key
     * @param string $height
     * @param string $width
     * @param string $length
     * @param string $extension
     */
    public function __construct(
        string $imageId,
        string $s3key,
        string $height,
        string $width,
        string $length,
        string $extension
    ){
        $this->imageId = $imageId;
        $this->s3key = $s3key;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getImageId(): string
    {
        return $this->imageId;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getLength(): string
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getS3key(): string
    {
        return $this->s3key;
    }
}
