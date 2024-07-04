<?php

namespace App\Bundle\SystemConfigBundle\Application;

class SystemConfigSummaryGetDetailResult
{
    public int $rentalSpaceCompilationId;
    public string $accessKey;
    public int $orderNumber;
    public int $isActive;
    public string $createTime;
    public string $modificationTime;
    public string $titleJa;
    public string $usePurposeCategory;
    public string $subtitleJa;
    public ?string $catchJa;
    public string $summaryJa;
    public ?int $areaId;
    public ?string $lastUpdate;
    public ?string $metaKeyword;
    public ?string $metaDescription;
    public ?string $rentalSpaceIds;
    public ?array $rentalSpaceCompilationImages;

    /**
     * RentalSpaceCompilationResult constructor.
     * @param int $rentalSpaceCompilationId
     * @param string $accessKey
     * @param int $orderNumber
     * @param int $isActive
     * @param string $createTime
     * @param string $modificationTime
     * @param string $titleJa
     * @param string $usePurposeCategory
     * @param string $subtitleJa
     * @param string|null $catchJa
     * @param string $summaryJa
     * @param int|null $areaId
     * @param string|null $lastUpdate
     * @param string|null $metaKeyword
     * @param string|null $metaDescription
     * @param string|null $rentalSpaceIds
     * @param array|null $rentalSpaceCompilationImages
     */
    public function __construct(
        int $rentalSpaceCompilationId,
        string $accessKey,
        int $orderNumber,
        int $isActive,
        string $createTime,
        string $modificationTime,
        string $titleJa,
        string $usePurposeCategory,
        string $subtitleJa,
        ?string $catchJa,
        string $summaryJa,
        ?int $areaId,
        ?string $lastUpdate,
        ?string $metaKeyword,
        ?string $metaDescription,
        ?string $rentalSpaceIds,
        ?array $rentalSpaceCompilationImages
    )
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
        $this->accessKey = $accessKey;
        $this->orderNumber = $orderNumber;
        $this->isActive = $isActive;
        $this->createTime = $createTime;
        $this->modificationTime = $modificationTime;
        $this->titleJa = $titleJa;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->subtitleJa = $subtitleJa;
        $this->catchJa = $catchJa;
        $this->summaryJa = $summaryJa;
        $this->areaId = $areaId;
        $this->lastUpdate = $lastUpdate;
        $this->metaKeyword = $metaKeyword;
        $this->metaDescription = $metaDescription;
        $this->rentalSpaceIds = $rentalSpaceIds;
        $this->rentalSpaceCompilationImages = $rentalSpaceCompilationImages;
    }
}
