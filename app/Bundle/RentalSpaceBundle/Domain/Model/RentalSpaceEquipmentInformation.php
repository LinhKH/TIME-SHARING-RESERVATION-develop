<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentInformation
{
    private RentalSpaceId $rentalSpaceId;
    private RentalSpaceEquipmentBasicInformation $equipmentBasicInformation;
    private RentalSpaceEquipmentGeneralInformation $equipmentGeneralInformation;
    private ?RentalSpaceEquipmentConferenceInformation $equipmentConferenceInformation;
    private ?RentalSpaceEquipmentShootingInformation $equipmentShootingInformation;
    private ?RentalSpaceEquipmentEventInformation $equipmentEventInformation;
    private ?RentalSpaceEquipmentPartyInformation $equipmentPartyInformation;
    private ?RentalSpaceEquipmentShareInformation $equipmentShareInformation;

    /**
     * Domain Equipment Information
     *
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceEquipmentBasicInformation $equipmentBasicInformation
     * @param RentalSpaceEquipmentGeneralInformation $equipmentGeneralInformation
     * @param RentalSpaceEquipmentConferenceInformation|null $equipmentConferenceInformation
     * @param RentalSpaceEquipmentShootingInformation|null $equipmentShootingInformation
     * @param RentalSpaceEquipmentEventInformation|null $equipmentEventInformation
     * @param RentalSpaceEquipmentPartyInformation|null $equipmentPartyInformation
     * @param RentalSpaceEquipmentShareInformation|null $equipmentShareInformation
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        RentalSpaceEquipmentBasicInformation $equipmentBasicInformation,
        RentalSpaceEquipmentGeneralInformation $equipmentGeneralInformation,
        ?RentalSpaceEquipmentConferenceInformation $equipmentConferenceInformation,
        ?RentalSpaceEquipmentShootingInformation $equipmentShootingInformation,
        ?RentalSpaceEquipmentEventInformation $equipmentEventInformation,
        ?RentalSpaceEquipmentPartyInformation $equipmentPartyInformation,
        ?RentalSpaceEquipmentShareInformation $equipmentShareInformation
    ) {
        $this->equipmentShareInformation = $equipmentShareInformation;
        $this->equipmentPartyInformation = $equipmentPartyInformation;
        $this->equipmentEventInformation = $equipmentEventInformation;
        $this->equipmentShootingInformation = $equipmentShootingInformation;
        $this->equipmentConferenceInformation = $equipmentConferenceInformation;
        $this->equipmentGeneralInformation = $equipmentGeneralInformation;
        $this->equipmentBasicInformation = $equipmentBasicInformation;
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
     * @return RentalSpaceEquipmentBasicInformation
     */
    public function getEquipmentBasicInformation(): RentalSpaceEquipmentBasicInformation
    {
        return $this->equipmentBasicInformation;
    }

    /**
     * @return RentalSpaceEquipmentGeneralInformation
     */
    public function getEquipmentGeneralInformation(): RentalSpaceEquipmentGeneralInformation
    {
        return $this->equipmentGeneralInformation;
    }

    /**
     * @return RentalSpaceEquipmentConferenceInformation|null
     */
    public function getEquipmentConferenceInformation(): ?RentalSpaceEquipmentConferenceInformation
    {
        return $this->equipmentConferenceInformation;
    }

    /**
     * @return RentalSpaceEquipmentShootingInformation|null
     */
    public function getEquipmentShootingInformation(): ?RentalSpaceEquipmentShootingInformation
    {
        return $this->equipmentShootingInformation;
    }

    /**
     * @return RentalSpaceEquipmentEventInformation|null
     */
    public function getEquipmentEventInformation(): ?RentalSpaceEquipmentEventInformation
    {
        return $this->equipmentEventInformation;
    }

    /**
     * @return RentalSpaceEquipmentPartyInformation|null
     */
    public function getEquipmentPartyInformation(): ?RentalSpaceEquipmentPartyInformation
    {
        return $this->equipmentPartyInformation;
    }

    /**
     * @return RentalSpaceEquipmentShareInformation|null
     */
    public function getEquipmentShareInformation(): ?RentalSpaceEquipmentShareInformation
    {
        return $this->equipmentShareInformation;
    }
}
