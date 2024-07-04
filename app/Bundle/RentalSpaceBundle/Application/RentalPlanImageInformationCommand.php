<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalPlanImageInformationCommand
{
    public string $extension;
    public string $length;
    public string $width;
    public string $height;
    public string $s3key;

    /**
     * @param string $s3key
     * @param string $height
     * @param string $width
     * @param string $length
     * @param string $extension
     */
    public function __construct(
        string $s3key,
        string $height,
        string $width,
        string $length,
        string $extension
    ){
        $this->s3key = $s3key;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->extension = $extension;
    }
}
