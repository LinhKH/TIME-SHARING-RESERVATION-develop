<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPostUploadImageCommand
{
    /**
     * @var int
     */
    public int $rentalSpaceCompilationId;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $type;

    /**
     * @var int
     */
    public int $width;

    /**
     * @var int
     */
    public int $height;

    /**
     * @var int
     */
    public int $length;

    /**
     * @var string
     */
    public string $extension;

    /**
     * @var string
     */
    public string $s3key;

    /**
     * SystemConfigSummaryPostUploadImageCommand constructor.
     * @param int $rentalSpaceCompilationId
     * @param string $name
     * @param int $type
     * @param int $width
     * @param int $height
     * @param int $length
     * @param string $extension
     * @param string $s3key
     */
    public function __construct(int $rentalSpaceCompilationId, string $name, int $type, int $width, int $height, int $length, string $extension, string $s3key)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
        $this->name = $name;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->extension = $extension;
        $this->s3key = $s3key;
    }
}
