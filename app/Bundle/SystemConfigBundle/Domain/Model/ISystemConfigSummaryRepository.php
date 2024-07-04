<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;

interface ISystemConfigSummaryRepository
{
    /**
     * @return int
     */
    public function getNextOrderNumber(): int;

    /**
     * @param RentalSpaceCompilation $rentalSpaceCompilation
     * @return RentalSpaceCompilationId
     */
    public function createSystemConfigSummary(RentalSpaceCompilation $rentalSpaceCompilation): RentalSpaceCompilationId;

    /**
     * @noparam
     * @return array{App\Bundle\Common\Domain\Model\Pagination, App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilation[]}|null
     */
    public function findAll(): ?array;

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @return RentalSpaceCompilation|null
     */
    public function findById(RentalSpaceCompilationId $rentalSpaceCompilationId): ?RentalSpaceCompilation;

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @return bool
     */
    public function delete(RentalSpaceCompilationId $rentalSpaceCompilationId): bool;

    /**
     * @param RentalSpaceCompilation $rentalSpaceCompilation
     * @return RentalSpaceCompilationId|null
     */
    public function updateSystemConfigSummary(RentalSpaceCompilation $rentalSpaceCompilation): ?RentalSpaceCompilationId;

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @param RentalSpaceCompilationImage $rentalSpaceCompilationImage
     * @return RentalSpaceCompilationImageId|null
     */
    public function uploadImageSystemConfigSummary(RentalSpaceCompilationId $rentalSpaceCompilationId, RentalSpaceCompilationImage $rentalSpaceCompilationImage): ?RentalSpaceCompilationImageId;

    /**
     * @param RentalSpaceCompilationImageId $rentalSpaceCompilationImageId
     * @return RentalSpaceCompilationImage|null
     */
    public function findImageSystemSummaryById(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId): ?RentalSpaceCompilationImage;

    /**
     * @param RentalSpaceCompilationImageId $rentalSpaceCompilationImageId
     * @return bool|null
     */
    public function deleteImageSystemSummary(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId): ?bool;

    /**
     * @param RentalSpaceCompilationImageId $rentalSpaceCompilationImageId
     * @param RentalSpaceCompilationImage $rentalSpaceCompilationImage
     * @return RentalSpaceCompilationImageId
     */
    public function updateImageSystemSummary(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId, RentalSpaceCompilationImage $rentalSpaceCompilationImage): RentalSpaceCompilationImageId;
}
