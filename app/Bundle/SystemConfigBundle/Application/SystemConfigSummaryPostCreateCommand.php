<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPostCreateCommand
{
    public int $active;
    public string $accessKey;
    public string $titleJa;
    public string $usePurposeCategory;
    public string $subtitleJa;
    public ?string $catchJa;
    public string $summaryJa;
    public ?int $areaId;
    public ?string $lastUpdate;
    public ?string $metaKeywords;
    public ?string $metaDescription;
    public ?string $rentalSpaceId;

    /**
     * SystemConfigSummaryPostCreateCommand constructor.
     * @param int $active
     * @param string $accessKey
     * @param string $titleJa
     * @param string $usePurposeCategory
     * @param string $subtitleJa
     * @param string|null $catchJa
     * @param string $summaryJa
     * @param int|null $areaId
     * @param string|null $lastUpdate
     * @param string|null $metaKeywords
     * @param string|null $metaDescription
     * @param string|null $rentalSpaceId
     */
    public function __construct(
        int $active,
        string $accessKey,
        string $titleJa,
        string $usePurposeCategory,
        string $subtitleJa,
        ?string $catchJa,
        string $summaryJa,
        ?int $areaId,
        ?string $lastUpdate,
        ?string $metaKeywords,
        ?string $metaDescription,
        ?string $rentalSpaceId
    )
    {
        $this->active = $active;
        $this->accessKey = $accessKey;
        $this->titleJa = $titleJa;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->subtitleJa = $subtitleJa;
        $this->catchJa = $catchJa;
        $this->summaryJa = $summaryJa;
        $this->areaId = $areaId;
        $this->lastUpdate = $lastUpdate;
        $this->metaKeywords = $metaKeywords;
        $this->metaDescription = $metaDescription;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @return string
     */
    public function getTitleJa(): string
    {
        return $this->titleJa;
    }

    /**
     * @return string
     */
    public function getUsePurposeCategory(): string
    {
        return $this->usePurposeCategory;
    }

    /**
     * @return string
     */
    public function getSubtitleJa(): string
    {
        return $this->subtitleJa;
    }

    /**
     * @return string|null
     */
    public function getCatchJa(): ?string
    {
        return $this->catchJa;
    }

    /**
     * @return string
     */
    public function getSummaryJa(): string
    {
        return $this->summaryJa;
    }

    /**
     * @return int|null
     */
    public function getAreaId(): ?int
    {
        return $this->areaId;
    }

    /**
     * @return string|null
     */
    public function getLastUpdate(): ?string
    {
        return $this->lastUpdate;
    }

    /**
     * @return string|null
     */
    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @return string|null
     */
    public function getRentalSpaceId(): ?string
    {
        return $this->rentalSpaceId;
    }
}
