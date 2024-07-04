<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilation;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationInfomation;
use App\Bundle\SystemConfigBundle\Domain\Model\AreaId;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationStatus;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigSummaryPostCreateApplicationService
{
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryPostCreateApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle(SystemConfigSummaryPostCreateCommand $command): SystemConfigSummaryPostCreateResult
    {
        $orderNumber = $this->systemConfigSummaryRepository->getNextOrderNumber();
        $rentalSpaceCompilation = new RentalSpaceCompilation(
            null,
            $command->accessKey,
            $orderNumber,
            RentalSpaceCompilationStatus::fromStatus($command->active),
            new DateTime('now'),
            new DateTime('now'),
            new RentalSpaceCompilationInfomation(
                $command->titleJa,
                $command->usePurposeCategory,
                $command->subtitleJa,
                $command->catchJa,
                $command->summaryJa,
                $command->areaId ? new AreaId($command->areaId) : null,
                new DateTime($command->lastUpdate),
                $command->metaKeywords,
                $command->metaDescription,
                json_decode($command->rentalSpaceId, true)
            ),
            null
        );

        DB::beginTransaction();
        try {
            $rentalSpaceCompilationId = $this->systemConfigSummaryRepository->createSystemConfigSummary($rentalSpaceCompilation);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            throw new TransactionException('更新できませんでした');
        }

        return new SystemConfigSummaryPostCreateResult(
            $rentalSpaceCompilationId->getValue()
        );
    }
}
