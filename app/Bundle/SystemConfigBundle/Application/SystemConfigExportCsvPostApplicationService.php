<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvExport;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvExportItem;
use App\Bundle\SystemConfigBundle\Domain\Model\ConfigCsvTargetType;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigCsvExportRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigExportCsvPostApplicationService
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
     * @param SystemConfigExportCsvPostCommand $commands
     * @return SystemConfigExportCsvPostResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(SystemConfigExportCsvPostCommand $commands): SystemConfigExportCsvPostResult
    {
        if (empty($commands)) {
            return new SystemConfigExportCsvPostResult(false);
        }
        $configCsvExportItems = [];
        foreach ($commands->configCsvItems as $command) {
            $configCsvExportItems[] = new ConfigCsvExportItem(
                ConfigCsvTargetType::fromValue($command->target),
                $command->id,
                $command->shown
            );
        }

        $configCsvExports = new ConfigCsvExport($configCsvExportItems);
        DB::beginTransaction();
        try {
            $systemConfigsUpdated = $this->systemConfigCSVRepository->updateConfigCsvExport($configCsvExports);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new SystemConfigExportCsvPostResult(
            $systemConfigsUpdated
        );
    }
}
