<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\DomainException;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImage;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

final class SystemConfigSummaryPutUpdateImageApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryPutUpdateImageApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(SystemConfigSummaryPutUpdateImageCommand $command): SystemConfigSummaryPutUpdateImageResult
    {
        $rentalSpaceCompilationImage = $this->systemConfigSummaryRepository->findImageSystemSummaryById(new RentalSpaceCompilationImageId($command->rentalSpaceCompilationImageId));
        if (!$rentalSpaceCompilationImage) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $rentalSpaceCompilationImageUpdate = new RentalSpaceCompilationImage(
            $rentalSpaceCompilationImage->getRentalSpaceCompilationImageId(),
            $rentalSpaceCompilationImage->getCreationTime(),
            $rentalSpaceCompilationImage->getName(),
            ($command->type >= 1 && $command->type <= 4) ? RentalSpaceCompilationImageType::fromType($command->type) : $rentalSpaceCompilationImage->getType(),
            $rentalSpaceCompilationImage->getWidth(),
            $rentalSpaceCompilationImage->getHeight(),
            $rentalSpaceCompilationImage->getLength(),
            $rentalSpaceCompilationImage->getExtension(),
            $rentalSpaceCompilationImage->getS3key(),
            $rentalSpaceCompilationImage->getParentId()
        );

        DB::beginTransaction();
        try {
            $rentalSpaceCompilationImageIdResult = $this->systemConfigSummaryRepository->updateImageSystemSummary($rentalSpaceCompilationImage->getRentalSpaceCompilationImageId(), $rentalSpaceCompilationImageUpdate);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new TransactionException('更新できませんでした');
        }
        return new SystemConfigSummaryPutUpdateImageResult(
            $rentalSpaceCompilationImageIdResult->asString()
        );
    }
}
