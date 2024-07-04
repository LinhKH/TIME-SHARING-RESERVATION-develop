<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentInformationPutCommand
{
    public RentalSpaceEquipmentBasicInformationCommand $basicInformationCommand;
    public RentalSpaceEquipmentGeneralInformationCommand $generalInformationCommand;
    public ?RentalSpaceEquipmentConferenceInformationCommand $conferenceInformationCommand;
    public ?RentalSpaceEquipmentShootingInformationCommand $shootingInformationCommand;
    public ?RentalSpaceEquipmentEventInformationCommand $eventInformationCommand;
    public ?RentalSpaceEquipmentPartyInformationCommand $partyInformationCommand;
    public ?RentalSpaceEquipmentShareInformationCommand $shareInformationCommand;
    public int $rentalSpaceId;

    /**
     * Equipment Information Command
     *
     * @param int $rentalSpaceId
     * @param RentalSpaceEquipmentBasicInformationCommand $basicInformationCommand
     * @param RentalSpaceEquipmentGeneralInformationCommand $generalInformationCommand
     * @param RentalSpaceEquipmentConferenceInformationCommand|null $conferenceInformationCommand
     * @param RentalSpaceEquipmentShootingInformationCommand|null $shootingInformationCommand
     * @param RentalSpaceEquipmentEventInformationCommand|null $eventInformationCommand
     * @param RentalSpaceEquipmentPartyInformationCommand|null $partyInformationCommand
     * @param RentalSpaceEquipmentShareInformationCommand|null $shareInformationCommand
     */
    public function __construct(
        int $rentalSpaceId,
        RentalSpaceEquipmentBasicInformationCommand $basicInformationCommand,
        RentalSpaceEquipmentGeneralInformationCommand $generalInformationCommand,
        ?RentalSpaceEquipmentConferenceInformationCommand $conferenceInformationCommand,
        ?RentalSpaceEquipmentShootingInformationCommand $shootingInformationCommand,
        ?RentalSpaceEquipmentEventInformationCommand $eventInformationCommand,
        ?RentalSpaceEquipmentPartyInformationCommand $partyInformationCommand,
        ?RentalSpaceEquipmentShareInformationCommand $shareInformationCommand
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->shareInformationCommand = $shareInformationCommand;
        $this->partyInformationCommand = $partyInformationCommand;
        $this->eventInformationCommand = $eventInformationCommand;
        $this->shootingInformationCommand = $shootingInformationCommand;
        $this->conferenceInformationCommand = $conferenceInformationCommand;
        $this->generalInformationCommand = $generalInformationCommand;
        $this->basicInformationCommand = $basicInformationCommand;
    }
}
