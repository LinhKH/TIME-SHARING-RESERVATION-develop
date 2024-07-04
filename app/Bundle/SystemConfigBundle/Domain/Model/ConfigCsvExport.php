<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class ConfigCsvExport
{
    private array $configCsvExport;

    /**
     * @param ConfigCsvExportItem[] $configCsvExport
     */
    public function __construct(
        array $configCsvExport
    ){
        $this->configCsvExport = $configCsvExport;
    }

    /**
     * @return ConfigCsvExportItem[]
     */
    public function getConfigCsvExport(): array
    {
        return $this->configCsvExport;
    }


}
