<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPostUploadImageResult
{
    /**
     * @var string
     */
    public string $rentalSpaceCompilationImageId;

    /**
     * SystemConfigSummaryPostUploadImageResult constructor.
     * @param string $rentalSpaceCompilationImageId
     */
    public function __construct(string $rentalSpaceCompilationImageId)
    {
        $this->rentalSpaceCompilationImageId = $rentalSpaceCompilationImageId;
    }
}
