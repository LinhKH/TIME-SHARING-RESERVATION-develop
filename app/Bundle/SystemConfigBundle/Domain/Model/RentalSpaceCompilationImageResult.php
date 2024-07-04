<?php


namespace App\Bundle\SystemConfigBundle\Domain\Model;


final class RentalSpaceCompilationImageResult
{
    public string $rentalSpaceCompilationImageId;
    public string $creationTime;
    public string $name;
    public int $type;
    public int $width;
    public int $height;
    public int $length;
    public string $extension;
    public string $s3key;
    public int $parentId;

    /**
     * RentalSpaceCompilationImageResult constructor.
     * @param string $rentalSpaceCompilationImageId
     * @param string $creationTime
     * @param string $name
     * @param int $type
     * @param int $width
     * @param int $height
     * @param int $length
     * @param string $extension
     * @param string $s3key
     * @param int $parentId
     */
    public function __construct(string $rentalSpaceCompilationImageId, string $creationTime, string $name, int $type, int $width, int $height, int $length, string $extension, string $s3key, int $parentId)
    {
        $this->rentalSpaceCompilationImageId = $rentalSpaceCompilationImageId;
        $this->creationTime = $creationTime;
        $this->name = $name;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->extension = $extension;
        $this->s3key = $s3key;
        $this->parentId = $parentId;
    }
}
