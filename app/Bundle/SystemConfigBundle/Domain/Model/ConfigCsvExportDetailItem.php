<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

class ConfigCsvExportDetailItem
{
    private int $shown;
    private ConfigCsvTargetType $target;
    private int $id;
    private string $field;
    private int $itemOrder;

    /**
     * @param int $id
     * @param ConfigCsvTargetType $target
     * @param string $field
     * @param int $itemOrder
     * @param int $shown
     */
    public function __construct(
        int $id,
        ConfigCsvTargetType $target,
        string $field,
        int $itemOrder,
        int $shown

    ){
        $this->itemOrder = $itemOrder;
        $this->field = $field;
        $this->id = $id;
        $this->target = $target;
        $this->shown = $shown;
    }

    /**
     * @return int
     */
    public function getShown(): int
    {
        return $this->shown;
    }

    /**
     * @return ConfigCsvTargetType
     */
    public function getTarget(): ConfigCsvTargetType
    {
        return $this->target;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return int
     */
    public function getItemOrder(): int
    {
        return $this->itemOrder;
    }

}
