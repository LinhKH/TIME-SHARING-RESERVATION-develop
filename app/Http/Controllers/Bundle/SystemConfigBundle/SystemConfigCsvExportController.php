<?php

namespace App\Http\Controllers\Bundle\SystemConfigBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Application\SystemConfigCsvExportByTargetDetailGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigCsvExportByTargetDetailGetCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigExportCsv;
use App\Bundle\SystemConfigBundle\Application\SystemConfigExportCsvPostApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigExportCsvPostCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\SystemConfigCsvExportRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigCsvExportRequest;
use App\Models\CsvExport;
use Illuminate\Http\JsonResponse;

class SystemConfigCsvExportController extends Controller
{

    /**
     * Update
     *
     * @param ConfigCsvExportRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws TransactionException
     */
    public function updateConfigCsvExport(ConfigCsvExportRequest $request): JsonResponse
    {
        $systemConfigCSVRepository = new SystemConfigCsvExportRepository();

        $applicationService = new SystemConfigExportCsvPostApplicationService(
            $systemConfigCSVRepository
        );

        $configCsvExportItems = [];
        if (!empty($request)) {
            foreach ($request['config_csv_export_items'] as $value) {
                $configCsvExportItems[] = new SystemConfigExportCsv(
                    $value['id'],
                    $value['target'],
                    $value['shown']
                );
            }
        }

        $command = new SystemConfigExportCsvPostCommand($configCsvExportItems);

        $applicationService->handle($command);

        return response()->json([
                'status'=> 200,
                'message' => 'Update CSV Export Output Successfully !'
        ], 200);
    }

    /**
     * Get list target CSV export
     */
    public function getListTargetConfigCsvExport(): JsonResponse
    {
        $targetConst = [
            [
                'target' => 'reservations',
                'title' => '予約リスト'
            ],
            [
                'target' => 'spaces',
                'title' => 'スペース'
            ],
            [
                'target' => 'organizations',
                'title' => '会社団体リスト'
            ],
            [
                'target' => 'users',
                'title' => 'オーナー'
            ],
            [
                'target' => 'customers',
                'title' => 'ユーザー'
            ],
            [
                'target' => 'inquiries',
                'title' => 'スペースへの問合せ'
            ],
            [
                'target' => 'contact-form',
                'title' => 'スペなびへの問合せ'
            ],
            [
                'target' => 'catering-inquiry-form',
                'title' => 'みんなのシェフ問合せ'
            ],
            [
                'target' => 'space-search-form',
                'title' => 'スペース探し問合せ'
            ],
            [
                'target' => 'yakatabune-inquiry',
                'title' => '屋形船問合せ'
            ]
        ];
        return response()->json([
            'status'=> 200,
            'data' => $targetConst
        ], 200);
    }

    /**
     * Detail by target
     */
    public function getDetailConfigCsvExportByTarget($target): JsonResponse
    {
        $systemConfigCSVRepository = new SystemConfigCsvExportRepository();

        $applicationService = new SystemConfigCsvExportByTargetDetailGetApplicationService(
            $systemConfigCSVRepository
        );
        if (!in_array($target, CsvExport::TARGETS)) {
            return response()->json([
                'status'=> 400,
                'message' => $target.' is not exist in system.'
            ], 200);
        }

        $command = new SystemConfigCsvExportByTargetDetailGetCommand($target);
        $configCsvExports = $applicationService->handle($command);

        $response = [];
        foreach ($configCsvExports->configCsvExports as $configCsvExport) {
            $response[] = [
                'id' => $configCsvExport->id,
                'target' => $configCsvExport->target,
                'field' => $configCsvExport->field,
                'item_order' => $configCsvExport->itemOrder,
                'shown' => $configCsvExport->shown
            ];
        }
        return response()->json([
            'status'=> 200,
            'data' => $response
        ], 200);

    }
}
