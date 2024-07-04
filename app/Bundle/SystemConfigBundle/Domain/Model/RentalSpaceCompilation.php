<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use DateTime;

final class RentalSpaceCompilation
{
    /**
     * @var RentalSpaceCompilationId|null
     */
    private ?RentalSpaceCompilationId $rentalSpaceCompilationId;

    /**
     * @var string
     */
    private string $accessKey;

    /**
     * @var int|null
     */
    private ?int $orderNumber;

    /**
     * @var RentalSpaceCompilationStatus
     */
    private RentalSpaceCompilationStatus $isActive;

    /**
     * @var DateTime
     */
    private DateTime $createTime;

    /**
     * @var DateTime
     */
    private DateTime $modificationTime;

    /**
     * @var RentalSpaceCompilationInfomation|null
     */
    private ?RentalSpaceCompilationInfomation $rentalSpaceCompilationInfomation;

    /**
     * @var RentalSpaceCompilationImage[]|null
     */
    private ?array $rentalSpaceCompilationImages;

    /**
     * RentalSpaceCompilation constructor.
     * @param RentalSpaceCompilationId|null $rentalSpaceCompilationId
     * @param string $accessKey
     * @param int|null $orderNumber
     * @param RentalSpaceCompilationStatus $isActive
     * @param DateTime $createTime
     * @param DateTime $modificationTime
     * @param RentalSpaceCompilationInfomation|null $rentalSpaceCompilationInfomation
     * @param RentalSpaceCompilationImage[]|null $rentalSpaceCompilationImages
     */
    public function __construct(?RentalSpaceCompilationId $rentalSpaceCompilationId, string $accessKey, ?int $orderNumber, RentalSpaceCompilationStatus $isActive, DateTime $createTime, DateTime $modificationTime, ?RentalSpaceCompilationInfomation $rentalSpaceCompilationInfomation, ?array $rentalSpaceCompilationImages)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
        $this->accessKey = $accessKey;
        $this->orderNumber = $orderNumber;
        $this->isActive = $isActive;
        $this->createTime = $createTime;
        $this->modificationTime = $modificationTime;
        $this->rentalSpaceCompilationInfomation = $rentalSpaceCompilationInfomation;
        $this->rentalSpaceCompilationImages = $rentalSpaceCompilationImages;
    }

    /**
     * @return RentalSpaceCompilationId|null
     */
    public function getRentalSpaceCompilationId(): ?RentalSpaceCompilationId
    {
        return $this->rentalSpaceCompilationId;
    }

    /**
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @return int|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @return RentalSpaceCompilationStatus
     */
    public function getIsActive(): RentalSpaceCompilationStatus
    {
        return $this->isActive;
    }

    /**
     * @return DateTime
     */
    public function getCreateTime(): DateTime
    {
        return $this->createTime;
    }

    /**
     * @return DateTime
     */
    public function getModificationTime(): DateTime
    {
        return $this->modificationTime;
    }

    /**
     * @return RentalSpaceCompilationInfomation|null
     */
    public function getRentalSpaceCompilationInfomation(): ?RentalSpaceCompilationInfomation
    {
        return $this->rentalSpaceCompilationInfomation;
    }

    /**
     * @return RentalSpaceCompilationImage[]|null
     */
    public function getRentalSpaceCompilationImages(): ?array
    {
        return $this->rentalSpaceCompilationImages;
    }
}
