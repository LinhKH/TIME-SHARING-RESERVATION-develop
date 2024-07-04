<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

interface ISystemConfigCsvExportRepository
{

    /**
     * @param ConfigCsvExport $configCsvExport
     * @return bool
     */
    public function updateConfigCsvExport(ConfigCsvExport $configCsvExport): bool;

    /**
     * @param ConfigCsvTargetType $csvTargetType
     * @return ConfigCsvExportDetailItem[]
     */
    public function detailConfigCsvExportByTarget(ConfigCsvTargetType $csvTargetType): array;
}
