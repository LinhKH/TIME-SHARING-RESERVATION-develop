<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvTargetType;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigCsvExportRepository;

final class SystemConfigCsvExportByTargetDetailGetApplicationService
{
    private ISystemConfigCsvExportRepository $systemConfigCSVRepository;

    /**
     * @param ISystemConfigCsvExportRepository $systemConfigCSVRepository
     */
    public function __construct(
        ISystemConfigCsvExportRepository $systemConfigCSVRepository
    ) {
        $this->systemConfigCSVRepository = $systemConfigCSVRepository;
    }

    /**
     * @param SystemConfigCsvExportByTargetDetailGetCommand $commands
     * @return SystemConfigCsvExportByTargetDetailGetResult
     * @throws InvalidArgumentException
     */
    public function handle(SystemConfigCsvExportByTargetDetailGetCommand $commands): SystemConfigCsvExportByTargetDetailGetResult
    {
        $configCsvExportQueries = $this->systemConfigCSVRepository->detailConfigCsvExportByTarget(ConfigCsvTargetType::fromValue($commands->target));
        $configCsvExports = [];

        foreach ($configCsvExportQueries as $configCsvExportDetailItem) {
            $configCsvExports[] = new SystemConfigCsvExportByTargetDetail(
                $configCsvExportDetailItem->getId(),
                $configCsvExportDetailItem->getTarget()->getValue(),
                $configCsvExportDetailItem->getField(),
                $configCsvExportDetailItem->getItemOrder(),
                $configCsvExportDetailItem->getShown()
            );
        }

        return new SystemConfigCsvExportByTargetDetailGetResult($configCsvExports);
    }
}
