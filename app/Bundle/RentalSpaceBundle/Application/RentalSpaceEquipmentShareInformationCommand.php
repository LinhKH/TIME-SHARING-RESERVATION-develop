<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentShareInformationCommand
{
    public ?bool $waterServer;
    public ?bool $treatmentTable;


    /**
     * Equipment Information : Share Information
     * @param bool|null $treatmentTable
     * @param bool|null $waterServer
     */
    public function __construct(
        ?bool $treatmentTable,
        ?bool $waterServer
    ){
        $this->treatmentTable = $treatmentTable;
        $this->waterServer = $waterServer;
    }
}
