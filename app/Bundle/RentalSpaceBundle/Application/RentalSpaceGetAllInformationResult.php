<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetAllInformationResult
{
    public ?RentalSpaceGetDetailGeneralResult $rentalSpaceGeneral;
    public ?array $rentalSpaceImages;
    public ?RentalSpaceGetDetailEquipmentInformationResult $rentalSpaceEquipmentInformation;
    public ?array $rentalSpacePlanAndInterval;
    public ?array $rentalSpacePage;
    public ?array $rentalSpaceEmailMessage;
    public ?array $rentalSpacePanoramaImages;
    public ?array $rentalSpaceFacadeImages;
    public ?array $rentalSpaceDirectionsStationImages;
    public ?array $rentalSpaceFloorPlanImages;

    /**
     * @param RentalSpaceGetDetailGeneralResult|null $rentalSpaceGeneral
     * @param RentalSpaceImageValueResult[]|null $rentalSpaceImages
     * @param RentalSpaceGetDetailEquipmentInformationResult|null $rentalSpaceEquipmentInformation
     * @param RentalSpaceGetDetailRentalSpaceIntervalResult[]|null $rentalSpacePlanAndInterval
     * @param RentalSpacePageAndEmailMessageObjectResult[]|null $rentalSpacePage
     * @param RentalSpacePageAndEmailMessageObjectResult[]|null $rentalSpaceEmailMessage
     * @param RentalSpaceImageValueResult[]|null $rentalSpacePanoramaImages
     * @param RentalSpaceImageValueResult[]|null $rentalSpaceFacadeImages
     * @param RentalSpaceImageValueResult[]|null $rentalSpaceDirectionsStationImages
     * @param RentalSpaceImageValueResult[]|null $rentalSpaceFloorPlanImages
     */
    public function __construct(
        ?RentalSpaceGetDetailGeneralResult $rentalSpaceGeneral,
        ?array $rentalSpaceImages,
        ?RentalSpaceGetDetailEquipmentInformationResult $rentalSpaceEquipmentInformation,
        ?array $rentalSpacePlanAndInterval,
        ?array $rentalSpacePage,
        ?array $rentalSpaceEmailMessage,
        ?array $rentalSpacePanoramaImages,
        ?array $rentalSpaceFacadeImages,
        ?array $rentalSpaceDirectionsStationImages,
        ?array $rentalSpaceFloorPlanImages
    ) {
        $this->rentalSpaceFloorPlanImages = $rentalSpaceFloorPlanImages;
        $this->rentalSpaceDirectionsStationImages = $rentalSpaceDirectionsStationImages;
        $this->rentalSpaceFacadeImages = $rentalSpaceFacadeImages;
        $this->rentalSpacePanoramaImages = $rentalSpacePanoramaImages;
        $this->rentalSpaceEmailMessage = $rentalSpaceEmailMessage;
        $this->rentalSpacePage = $rentalSpacePage;
        $this->rentalSpacePlanAndInterval = $rentalSpacePlanAndInterval;
        $this->rentalSpaceEquipmentInformation = $rentalSpaceEquipmentInformation;
        $this->rentalSpaceImages = $rentalSpaceImages;
        $this->rentalSpaceGeneral = $rentalSpaceGeneral;

    }
}
