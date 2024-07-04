<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigSummaryDeleteImageApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryDeleteImageApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @param SystemConfigSummaryDeleteImageCommand $command
     * @return SystemConfigSummaryDeleteImageResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(SystemConfigSummaryDeleteImageCommand $command): SystemConfigSummaryDeleteImageResult
    {
        $rentalSpaceCompilationImageId = new RentalSpaceCompilationImageId($command->rentalSpaceCompilationImageId);
        $rentalSpaceCompilationImage = $this->systemConfigSummaryRepository->findImageSystemSummaryById($rentalSpaceCompilationImageId);
        if (!$rentalSpaceCompilationImage) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $flag = false;
        DB::beginTransaction();
        try {
            $flag = $this->systemConfigSummaryRepository->deleteImageSystemSummary($rentalSpaceCompilationImageId);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new TransactionException('更新できませんでした');
        }

        return new SystemConfigSummaryDeleteImageResult(
            $flag
        );
    }
}
