<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigCsvExportByTargetDetailGetResult
{
    public array $configCsvExports;

    /**
     * @param SystemConfigCsvExportByTargetDetail[] $configCsvExports
     */
    public function __construct(
        array $configCsvExports
    ){
        $this->configCsvExports = $configCsvExports;
    }
}
