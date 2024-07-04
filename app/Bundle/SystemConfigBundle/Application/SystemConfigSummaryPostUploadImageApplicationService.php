<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImage;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageType;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigSummaryPostUploadImageApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryPostUploadImageApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @param SystemConfigSummaryPostUploadImageCommand $command
     * @return SystemConfigSummaryPostUploadImageResult
     * @throws RecordNotFoundException|InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(SystemConfigSummaryPostUploadImageCommand $command): SystemConfigSummaryPostUploadImageResult
    {
        $rentalSpaceCompilationId = new RentalSpaceCompilationId($command->rentalSpaceCompilationId);
        $rentalSpaceCompilation = $this->systemConfigSummaryRepository->findById($rentalSpaceCompilationId);
        $rentalSpaceCompilationImage = new RentalSpaceCompilationImage(
            null,
            new DateTime('now'),
            $command->name,
            RentalSpaceCompilationImageType::fromType($command->type),
            $command->width,
            $command->height,
            $command->length,
            $command->extension,
            $command->s3key,
            $rentalSpaceCompilationId
        );
        if (!$rentalSpaceCompilation) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        DB::beginTransaction();
        try {
            $rentalSpaceCompilationImageId = $this->systemConfigSummaryRepository->uploadImageSystemConfigSummary($rentalSpaceCompilationId, $rentalSpaceCompilationImage);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            throw new TransactionException('更新できませんでした');
        }
        return new SystemConfigSummaryPostUploadImageResult(
            $rentalSpaceCompilationImageId->asString()
        );
    }
}
