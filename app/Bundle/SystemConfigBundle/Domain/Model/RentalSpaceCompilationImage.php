<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use DateTime;

final class RentalSpaceCompilationImage
{
    /**
     * @var RentalSpaceCompilationImageId|null
     */
    private ?RentalSpaceCompilationImageId $rentalSpaceCompilationImageId;

    /**
     * @var DateTime
     */
    private DateTime $creationTime;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var RentalSpaceCompilationImageType
     */
    private RentalSpaceCompilationImageType $type;

    /**
     * @var int
     */
    private int $width;

    /**
     * @var int
     */
    private int $height;

    /**
     * @var int
     */
    private int $length;

    /**
     * @var string
     */
    private string $extension;

    /**
     * @var string
     */
    private string $s3key;

    /**
     * @var RentalSpaceCompilationId
     */
    private RentalSpaceCompilationId $parentId;

    /**
     * RentalSpaceCompilationImage constructor.
     * @param RentalSpaceCompilationImageId|null $rentalSpaceCompilationImageId
     * @param DateTime $creationTime
     * @param string $name
     * @param RentalSpaceCompilationImageType $type
     * @param int $width
     * @param int $height
     * @param int $length
     * @param string $extension
     * @param string $s3key
     * @param RentalSpaceCompilationId $parentId
     */
    public function __construct(?RentalSpaceCompilationImageId $rentalSpaceCompilationImageId, DateTime $creationTime, string $name, RentalSpaceCompilationImageType $type, int $width, int $height, int $length, string $extension, string $s3key, RentalSpaceCompilationId $parentId)
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

    /**
     * @return RentalSpaceCompilationImageId|null
     */
    public function getRentalSpaceCompilationImageId(): ?RentalSpaceCompilationImageId
    {
        return $this->rentalSpaceCompilationImageId;
    }

    /**
     * @return DateTime
     */
    public function getCreationTime(): DateTime
    {
        return $this->creationTime;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return RentalSpaceCompilationImageType
     */
    public function getType(): RentalSpaceCompilationImageType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
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
    public function getS3key(): string
    {
        return $this->s3key;
    }

    /**
     * @return RentalSpaceCompilationId
     */
    public function getParentId(): RentalSpaceCompilationId
    {
        return $this->parentId;
    }
}
