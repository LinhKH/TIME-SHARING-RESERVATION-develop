<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceImageRepository
{
    /**
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpaceImage(RentalSpace $rentalSpace): array;

    /**
     * Find rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     */
    public function findAllPanoramaImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     */
    public function findAllFacadeImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     */
    public function findAllDirectionStationImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     */
    public function findAllFloorPlanImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage;

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool|null
     */
    public function deleteImageById(RentalSpaceImageId $rentalSpaceImageId): bool;

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool|null
     */
    public function deletePanoramaImageById(RentalSpaceImageId $rentalSpaceImageId): bool;

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool|null
     */
    public function deleteFacadeImageById(RentalSpaceImageId $rentalSpaceImageId): bool;

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool|null
     */
    public function deleteDirectionStationImageById(RentalSpaceImageId $rentalSpaceImageId): bool;

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool|null
     */
    public function deleteFloorPlanImageById(RentalSpaceImageId $rentalSpaceImageId): bool;


    /**
     * @param RentalSpaceImageTitleEav $rentalSpaceImageTitleEav
     * @return RentalSpaceImageId|null
     */
    public function updateTitleImageWithType(RentalSpaceImageTitleEav $rentalSpaceImageTitleEav): ?RentalSpaceImageId;
}
