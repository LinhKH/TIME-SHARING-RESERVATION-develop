<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;


final class RentalSpaceAllInformation
{
    private RentalSpaceId $rentalSpaceId;
    private ?RentalSpaceGeneral $rentalSpaceGeneral;
    private ?array $rentalSpaceImage;
    private ?RentalSpaceEquipmentInformation $rentalSpaceEquipmentInformation;
    private ?array $rentalSpacePlanAndInterval;
    private ?array $rentalSpacePage;
    private ?array $rentalSpaceEmailMessage;
    private ?array $rentalSpacePanoramaImage;
    private ?array $rentalSpaceFacadeImage;
    private ?array $rentalSpaceDirectionsStationImage;
    private ?array $rentalSpaceFloorPlanImage;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceGeneral|null $rentalSpaceGeneral
     * @param RentalSpaceImageValue[]|null $rentalSpaceImage
     * @param RentalSpaceEquipmentInformation|null $rentalSpaceEquipmentInformation
     * @param RentalIntervalInformation[]|null $rentalSpacePlanAndInterval
     * @param RentalSpaceGetPageAndEmailMessageAllInformation[]|null $rentalSpacePage
     * @param RentalSpaceGetPageAndEmailMessageAllInformation[]|null $rentalSpaceEmailMessage
     * @param RentalSpaceImageValue[]|null $rentalSpacePanoramaImage
     * @param RentalSpaceImageValue[]|null $rentalSpaceFacadeImage
     * @param RentalSpaceImageValue[]|null $rentalSpaceDirectionsStationImage
     * @param RentalSpaceImageValue[]|null $rentalSpaceFloorPlanImage
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        ?RentalSpaceGeneral $rentalSpaceGeneral,
        ?array $rentalSpaceImage,
        ?RentalSpaceEquipmentInformation $rentalSpaceEquipmentInformation,
        ?array $rentalSpacePlanAndInterval,
        ?array $rentalSpacePage,
        ?array $rentalSpaceEmailMessage,
        ?array $rentalSpacePanoramaImage,
        ?array $rentalSpaceFacadeImage,
        ?array $rentalSpaceDirectionsStationImage,
        ?array $rentalSpaceFloorPlanImage
    ){
        $this->rentalSpaceFloorPlanImage = $rentalSpaceFloorPlanImage;
        $this->rentalSpaceDirectionsStationImage = $rentalSpaceDirectionsStationImage;
        $this->rentalSpaceFacadeImage = $rentalSpaceFacadeImage;
        $this->rentalSpacePanoramaImage = $rentalSpacePanoramaImage;
        $this->rentalSpaceEmailMessage = $rentalSpaceEmailMessage;
        $this->rentalSpacePage = $rentalSpacePage;
        $this->rentalSpacePlanAndInterval = $rentalSpacePlanAndInterval;
        $this->rentalSpaceEquipmentInformation = $rentalSpaceEquipmentInformation;
        $this->rentalSpaceImage = $rentalSpaceImage;
        $this->rentalSpaceGeneral = $rentalSpaceGeneral;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalSpaceGeneral|null
     */
    public function getRentalSpaceGeneral(): ?RentalSpaceGeneral
    {
        return $this->rentalSpaceGeneral;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceImage(): ?array
    {
        return $this->rentalSpaceImage;
    }

    /**
     * @return RentalSpaceEquipmentInformation|null
     */
    public function getRentalSpaceEquipmentInformation(): ?RentalSpaceEquipmentInformation
    {
        return $this->rentalSpaceEquipmentInformation;
    }

    /**
     * @return array|null
     */
    public function getRentalSpacePlanAndInterval(): ?array
    {
        return $this->rentalSpacePlanAndInterval;
    }

    /**
     * @return array|null
     */
    public function getRentalSpacePage(): ?array
    {
        return $this->rentalSpacePage;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceEmailMessage(): ?array
    {
        return $this->rentalSpaceEmailMessage;
    }

    /**
     * @return array|null
     */
    public function getRentalSpacePanoramaImage(): ?array
    {
        return $this->rentalSpacePanoramaImage;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceFacadeImage(): ?array
    {
        return $this->rentalSpaceFacadeImage;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceDirectionsStationImage(): ?array
    {
        return $this->rentalSpaceDirectionsStationImage;
    }

    /**
     * @return array|null
     */
    public function getRentalSpaceFloorPlanImage(): ?array
    {
        return $this->rentalSpaceFloorPlanImage;
    }

}
