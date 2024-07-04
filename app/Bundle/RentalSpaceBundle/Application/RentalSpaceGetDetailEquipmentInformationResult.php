<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentBasicInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentConferenceInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentEventInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentGeneralInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentPartyInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShareInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShootingInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailEquipmentInformationResult
{
    public int $rentalSpaceId;
    public array $equipmentBasicInformation;
    public array $equipmentGeneralInformation;
    public ?array $equipmentConferenceInformation;
    public ?array $equipmentShootingInformation;
    public ?array $equipmentEventInformation;
    public ?array $equipmentPartyInformation;
    public ?array $equipmentShareInformation;

    /**
     * Domain Equipment Information
     *
     * @param int $rentalSpaceId
     * @param array $equipmentBasicInformation
     * @param array $equipmentGeneralInformation
     * @param array|null $equipmentConferenceInformation
     * @param array|null $equipmentShootingInformation
     * @param array|null $equipmentEventInformation
     * @param array|null $equipmentPartyInformation
     * @param array|null $equipmentShareInformation
     */
    public function __construct(
        int $rentalSpaceId,
        array $equipmentBasicInformation,
        array $equipmentGeneralInformation,
        ?array $equipmentConferenceInformation,
        ?array $equipmentShootingInformation,
        ?array $equipmentEventInformation,
        ?array $equipmentPartyInformation,
        ?array $equipmentShareInformation
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
}
