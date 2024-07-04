<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class ConfigCsvExportItem
{
    private int $shown;
    private int $id;
    private ConfigCsvTargetType $target;

    /**
     * @param ConfigCsvTargetType $target
     * @param int $id
     * @param int $shown
     */
    public function __construct(
        ConfigCsvTargetType $target,
        int $id,
        int $shown

    ){
        $this->target = $target;
        $this->id = $id;
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ConfigCsvTargetType
     */
    public function getTarget(): ConfigCsvTargetType
    {
        return $this->target;
    }
}
