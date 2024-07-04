<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigSummaryDeleteApplicationService
{
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryDeleteApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @param SystemConfigSummaryDeleteCommand $command
     * @return SystemConfigSummaryDeleteResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     * @throws Exception
     */
    public function handle(SystemConfigSummaryDeleteCommand $command): SystemConfigSummaryDeleteResult
    {
        $rentalSpaceCompilationId = new RentalSpaceCompilationId($command->rentalSpaceCompilationId);
        $rentalSpaceCompilation = $this->systemConfigSummaryRepository->findById($rentalSpaceCompilationId);
        if (empty($rentalSpaceCompilation)) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $flag = false;
        DB::beginTransaction();
        try {
            $flag = $this->systemConfigSummaryRepository->delete($rentalSpaceCompilationId);
            DB::commit();
        } catch (Exception $exception)
        {
            DB::rollBack();
            Log::error($exception);
            throw new TransactionException('更新できませんでした');
        }
        return new SystemConfigSummaryDeleteResult(
            $flag
        );
    }
}
