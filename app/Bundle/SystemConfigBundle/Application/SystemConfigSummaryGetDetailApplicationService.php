<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageResult;
use Illuminate\Support\Facades\Storage;

final class SystemConfigSummaryGetDetailApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryGetDetailApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @param SystemConfigSummaryGetDetailCommand $command
     * @return SystemConfigSummaryGetDetailResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(SystemConfigSummaryGetDetailCommand $command): SystemConfigSummaryGetDetailResult
    {
        $rentalSpaceCompilationId = new RentalSpaceCompilationId($command->rentalSpaceCompilationId);
        $rentalSpaceCompilation = $this->systemConfigSummaryRepository->findById($rentalSpaceCompilationId);
        if (!$rentalSpaceCompilation) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $rentalSpaceCompilationImageResult = [];
        if ($rentalSpaceCompilation->getRentalSpaceCompilationImages()) {
            foreach ($rentalSpaceCompilation->getRentalSpaceCompilationImages() as $rentalSpaceCompilationImage) {
                $rentalSpaceCompilationImageResult[] = new RentalSpaceCompilationImageResult(
                    $rentalSpaceCompilationImage->getRentalSpaceCompilationImageId()->asString(),
                    $rentalSpaceCompilationImage->getCreationTime()->format('m/d/Y'),
                    $rentalSpaceCompilationImage->getName(),
                    $rentalSpaceCompilationImage->getType()->getType(),
                    $rentalSpaceCompilationImage->getWidth(),
                    $rentalSpaceCompilationImage->getHeight(),
                    $rentalSpaceCompilationImage->getLength(),
                    $rentalSpaceCompilationImage->getExtension(),
                    Storage::url($rentalSpaceCompilationImage->getS3key()),
                    $rentalSpaceCompilationImage->getParentId()->getValue(),
                );
            }
        }
        return new SystemConfigSummaryGetDetailResult(
            $rentalSpaceCompilation->getRentalSpaceCompilationId()->getValue(),
            $rentalSpaceCompilation->getAccessKey(),
            $rentalSpaceCompilation->getOrderNumber(),
            $rentalSpaceCompilation->getIsActive()->getStatus(),
            $rentalSpaceCompilation->getCreateTime()->format('m/d/Y'),
            $rentalSpaceCompilation->getModificationTime()->format('m/d/Y'),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getTitleJa(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getUsePurposeCategory(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getSubtitleJa(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getCatchJa(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getSummaryJa(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getAreaId() ? $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getAreaId()->getValue() : null,
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getLastUpdate()->format('m/d/Y'),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getMetaKeyword(),
            $rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getMetaDescription(),
            json_encode($rentalSpaceCompilation->getRentalSpaceCompilationInfomation()->getRentalSpaceIds(), JSON_UNESCAPED_SLASHES),
            $rentalSpaceCompilationImageResult
        );
    }
}
