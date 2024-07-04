<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\AreaId;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilation;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationInfomation;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationStatus;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SystemConfigSummaryPutUpdateApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryPutUpdateApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @throws RecordNotFoundException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle(SystemConfigSummaryPutUpdateCommand $command): SystemConfigSummaryPutUpdateResult
    {
        $rentalSpaceCompilation = $this->systemConfigSummaryRepository->findById(new RentalSpaceCompilationId($command->rentalSpaceCompilationId));
        if (!$rentalSpaceCompilation) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $rentalSpaceCompilationUpdateData = new RentalSpaceCompilation(
            $rentalSpaceCompilation->getRentalSpaceCompilationId(),
            $command->accessKey ?? $rentalSpaceCompilation->getAccessKey(),
            $rentalSpaceCompilation->getOrderNumber(),
            is_numeric($command->getActive()) ? RentalSpaceCompilationStatus::fromStatus($command->getActive()) : $rentalSpaceCompilation->getIsActive(),
            $rentalSpaceCompilation->getCreateTime(),
            new DateTime('now'),
            new RentalSpaceCompilationInfomation(
                $command->titleJa ?? $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getTitleJa(),
                $command->usePurposeCategory ?? $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getUsePurposeCategory(),
                $command->subtitleJa ?? $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getSubtitleJa(),
                $command->catchJa,
                $command->summaryJa ?? $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getSummaryJa(),
                $command->areaId ? new AreaId($command->areaId) : $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getAreaId(),
                new DateTime($command->lastUpdate),
                $command->metaKeywords,
                $command->metaDescription,
                $command->rentalSpaceId ? json_decode($command->rentalSpaceId, true) : $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getRentalSpaceIds(),
            ),
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceCompilationId = $this->systemConfigSummaryRepository->updateSystemConfigSummary($rentalSpaceCompilationUpdateData);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            throw new TransactionException('更新できませんでした');
        }
        return new SystemConfigSummaryPutUpdateResult(
            $rentalSpaceCompilationId->getValue()
        );
    }
}
