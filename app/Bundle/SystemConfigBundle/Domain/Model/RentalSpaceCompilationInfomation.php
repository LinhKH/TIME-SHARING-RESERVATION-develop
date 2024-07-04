<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use DateTime;

final class RentalSpaceCompilationInfomation
{
    private string $titleJa;
    private string $usePurposeCategory;
    private string $subtitleJa;
    private ?string $catchJa;
    private string $summaryJa;
    private ?AreaId $areaId;
    private ?DateTime $lastUpdate;
    private ?string $metaKeyword;
    private ?string $metaDescription;
    private ?array $rentalSpaceIds;

    /**
     * RentalSpaceCompilationInfomation constructor.
     * @param string $titleJa
     * @param string $usePurposeCategory
     * @param string $subtitleJa
     * @param string|null $catchJa
     * @param string $summaryJa
     * @param AreaId|null $areaId
     * @param DateTime $lastUpdate
     * @param string|null $metaKeyword
     * @param string|null $metaDescription
     * @param array|null $rentalSpaceIds
     */
    public function __construct(
        string $titleJa,
        string $usePurposeCategory,
        string $subtitleJa,
        ?string $catchJa,
        string $summaryJa,
        ?AreaId $areaId,
        DateTime $lastUpdate,
        ?string $metaKeyword,
        ?string $metaDescription,
        ?array $rentalSpaceIds
    )
    {
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
     * @return AreaId|null
     */
    public function getAreaId(): ?AreaId
    {
        return $this->areaId;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdate(): ?DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @return string|null
     */
    public function getMetaKeyword(): ?string
    {
        return $this->metaKeyword;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceIds(): ?array
    {
        return $this->rentalSpaceIds;
    }
}
