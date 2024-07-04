<?php

namespace App\Bundle\SystemConfigBundle\Infrastructure;

use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvExport;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvExportDetailItem;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvTargetType;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigCsvExportRepository;
use App\Models\CsvExport as ModelCsvExport;

class SystemConfigCsvExportRepository implements ISystemConfigCsvExportRepository
{

    /**
     * Update
     *
     * @param ConfigCsvExport $configCsvExport
     * @return bool
     */
    public function updateConfigCsvExport(ConfigCsvExport $configCsvExport): bool
    {
        // TODO: Implement updateConfigCsvExport() method.
        foreach ($configCsvExport->getConfigCsvExport() as $configCsvExportItem) {
            $entity = ModelCsvExport::where('id', $configCsvExportItem->getId())->where('target', $configCsvExportItem->getTarget()->getValue())->first();
            $entity->shown = $configCsvExportItem->getShown();
            $entity->save();
        }
        return true;
    }

    /**
     * Detail By Target
     *
     * @param ConfigCsvTargetType $csvTargetType
     * @return ConfigCsvExportDetailItem[]
     */
    public function detailConfigCsvExportByTarget(ConfigCsvTargetType $csvTargetType): array
    {
        // TODO: Implement detailConfigCsvExportByTarget() method.
        $entities = ModelCsvExport::where('target', $csvTargetType->getValue())->get()->toArray();
        $configCsvExports = [];

        foreach ($entities as $entity) {
            $configCsvExports[] = new ConfigCsvExportDetailItem(
              $entity['id'],
                ConfigCsvTargetType::fromValue($entity['target']),
                $entity['field'],
                $entity['item_order'],
                $entity['shown']
            );
        }

        return $configCsvExports;
    }
}
