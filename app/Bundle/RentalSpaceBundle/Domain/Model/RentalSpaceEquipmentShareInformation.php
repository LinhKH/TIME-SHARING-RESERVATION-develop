<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentShareInformation
{
    private ?bool $waterServer;
    private ?bool $treatmentTable;


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

    /**
     * @return bool|null
     */
    public function getWaterServer(): ?bool
    {
        return $this->waterServer;
    }

    /**
     * @return bool|null
     */
    public function getTreatmentTable(): ?bool
    {
        return $this->treatmentTable;
    }


}
