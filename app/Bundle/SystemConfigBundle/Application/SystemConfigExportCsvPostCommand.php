<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigExportCsvPostCommand
{
    public array $configCsvItems;

    /**
     * @param SystemConfigExportCsv[] $configCsvItems
     */
    public function __construct(
        array $configCsvItems
    ){
        $this->configCsvItems = $configCsvItems;
    }
}
