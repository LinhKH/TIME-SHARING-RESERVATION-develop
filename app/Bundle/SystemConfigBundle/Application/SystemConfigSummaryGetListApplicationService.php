<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\PaginationResult;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageResult;
use Illuminate\Support\Facades\Storage;

class SystemConfigSummaryGetListApplicationService
{
    /**
     * @var ISystemConfigSummaryRepository
     */
    private ISystemConfigSummaryRepository $systemConfigSummaryRepository;

    /**
     * SystemConfigSummaryGetListApplicationService constructor.
     * @param ISystemConfigSummaryRepository $systemConfigSummaryRepository
     */
    public function __construct(ISystemConfigSummaryRepository $systemConfigSummaryRepository)
    {
        $this->systemConfigSummaryRepository = $systemConfigSummaryRepository;
    }

    /**
     * @param SystemConfigSummaryGetListCommand $command
     * @return SystemConfigSummaryGetListResult
     */
    public function handle(SystemConfigSummaryGetListCommand $command): SystemConfigSummaryGetListResult
    {
        [$pagination, $rentalSpaceCompilations] = $this->systemConfigSummaryRepository->findAll();

        $rentalSpaceCompilationResults = [];
        if (!empty($rentalSpaceCompilations)) {
            foreach ($rentalSpaceCompilations as $rentalSpaceCompilation) {
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
                $rentalSpaceCompilationResult = new RentalSpaceCompilationResult(
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
                $rentalSpaceCompilationResults[] = $rentalSpaceCompilationResult;
            }
        }

        return new SystemConfigSummaryGetListResult(
            new PaginationResult(
                $pagination->getTotalPages(),
                $pagination->getPerPage(),
                $pagination->getCurrentPage()
            ),
            $rentalSpaceCompilationResults
        );
    }
}
