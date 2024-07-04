<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpace
{
    private ?RentalSpaceId $rentalSpaceId;
    private ?RentalSpaceGeneral $rentalSpaceGeneral;
    private ?RentalSpaceImage $rentalSpaceImage;
    private ?RentalSpaceDraftStep $draftStep;
    private ?RentalSpaceEquipmentInformation $rentalSpaceEquipmentInformation;
    private ?RentalSpaceBookingSystem $rentalSpaceBookingSystem;
    private ?RentalSpaceReservationOptionTypes $rentalSpaceReservationOptionTypes;
    private ?RentalSpaceRentalPlan $rentalSpaceRentalPlan;
    private ?RentalSpaceRentalInterval $rentalSpaceRentalInterval;
    private ?RentalSpacePageAndEmailMessage $rentalSpacePageAndEmailMessage;
    private ?RentalSpaceApproval $rentalSpaceApproval;
    private ?RentalSpaceRentalPlanGroup $rentalSpaceRentalPlanGroup;

    /**
     * @param RentalSpaceId|null $rentalSpaceId
     * @param RentalSpaceDraftStep|null $draftStep
     * @param RentalSpaceGeneral|null $rentalSpaceGeneral
     * @param RentalSpaceImage|null $rentalSpaceImage
     * @param RentalSpaceEquipmentInformation|null $rentalSpaceEquipmentInformation
     * @param RentalSpaceBookingSystem|null $rentalSpaceBookingSystem
     * @param RentalSpaceReservationOptionTypes|null $rentalSpaceReservationOptionTypes
     * @param RentalSpaceRentalPlan|null $rentalSpaceRentalPlan
     * @param RentalSpaceRentalInterval|null $rentalSpaceRentalInterval
     * @param RentalSpacePageAndEmailMessage|null $rentalSpacePageAndEmailMessage
     * @param RentalSpaceApproval|null $rentalSpaceApproval
     * @param RentalSpaceRentalPlanGroup|null $rentalSpaceRentalPlanGroup
     */
    public function __construct(
        ?RentalSpaceId $rentalSpaceId,
        ?RentalSpaceDraftStep $draftStep,
        ?RentalSpaceGeneral $rentalSpaceGeneral,
        ?RentalSpaceImage $rentalSpaceImage,
        ?RentalSpaceEquipmentInformation $rentalSpaceEquipmentInformation,
        ?RentalSpaceBookingSystem $rentalSpaceBookingSystem,
        ?RentalSpaceReservationOptionTypes $rentalSpaceReservationOptionTypes,
        ?RentalSpaceRentalPlan $rentalSpaceRentalPlan,
        ?RentalSpaceRentalInterval $rentalSpaceRentalInterval,
        ?RentalSpacePageAndEmailMessage $rentalSpacePageAndEmailMessage,
        ?RentalSpaceApproval $rentalSpaceApproval,
        ?RentalSpaceRentalPlanGroup $rentalSpaceRentalPlanGroup
    ) {
        $this->rentalSpaceRentalPlanGroup = $rentalSpaceRentalPlanGroup;
        $this->rentalSpaceApproval = $rentalSpaceApproval;
        $this->rentalSpacePageAndEmailMessage = $rentalSpacePageAndEmailMessage;
        $this->rentalSpaceRentalInterval = $rentalSpaceRentalInterval;
        $this->rentalSpaceRentalPlan = $rentalSpaceRentalPlan;
        $this->rentalSpaceReservationOptionTypes = $rentalSpaceReservationOptionTypes;
        $this->rentalSpaceBookingSystem = $rentalSpaceBookingSystem;
        $this->rentalSpaceEquipmentInformation = $rentalSpaceEquipmentInformation;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalSpaceGeneral = $rentalSpaceGeneral;
        $this->draftStep = $draftStep;
        $this->rentalSpaceImage = $rentalSpaceImage;
    }

    /**
     * @return RentalSpaceImage|null
     */
    public function getRentalSpaceImage(): ?RentalSpaceImage
    {
        return $this->rentalSpaceImage;
    }

    /**
     * @return RentalSpaceDraftStep|null
     */
    public function getDraftStep(): ?RentalSpaceDraftStep
    {
        return $this->draftStep;
    }

    /**
     * @return RentalSpaceId|null
     */
    public function getRentalSpaceId(): ?RentalSpaceId
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
     * @return RentalSpaceEquipmentInformation|null
     */
    public function getRentalSpaceEquipmentInformation(): ?RentalSpaceEquipmentInformation
    {
        return $this->rentalSpaceEquipmentInformation;
    }

    /**
     * @return RentalSpaceBookingSystem|null
     */
    public function getRentalSpaceBookingSystem(): ?RentalSpaceBookingSystem
    {
        return $this->rentalSpaceBookingSystem;
    }

    /**
     * @return RentalSpaceReservationOptionTypes|null
     */
    public function getRentalSpaceReservationOptionTypes(): ?RentalSpaceReservationOptionTypes
    {
        return $this->rentalSpaceReservationOptionTypes;
    }

    /**
     * @return RentalSpaceRentalPlan|null
     */
    public function getRentalSpaceRentalPlan(): ?RentalSpaceRentalPlan
    {
        return $this->rentalSpaceRentalPlan;
    }

    /**
     * @return RentalSpaceRentalInterval|null
     */
    public function getRentalSpaceRentalInterval(): ?RentalSpaceRentalInterval
    {
        return $this->rentalSpaceRentalInterval;
    }

    /**
     * @return RentalSpacePageAndEmailMessage|null
     */
    public function getRentalSpacePageAndEmailMessage(): ?RentalSpacePageAndEmailMessage
    {
        return $this->rentalSpacePageAndEmailMessage;
    }

    /**
     * @return RentalSpaceApproval|null
     */
    public function getRentalSpaceApproval(): ?RentalSpaceApproval
    {
        return $this->rentalSpaceApproval;
    }

    /**
     * @return RentalSpaceRentalPlanGroup|null
     */
    public function getRentalSpaceRentalPlanGroup(): ?RentalSpaceRentalPlanGroup
    {
        return $this->rentalSpaceRentalPlanGroup;
    }

}
