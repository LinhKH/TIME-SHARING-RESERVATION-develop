<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPutUpdateImageResult
{
    public string $rentalSpaceCompilationImageId;

    /**
     * SystemConfigSummaryPutUpdateImageResult constructor.
     * @param string $rentalSpaceCompilationImageId
     */
    public function __construct(string $rentalSpaceCompilationImageId)
    {
        $this->rentalSpaceCompilationImageId = $rentalSpaceCompilationImageId;
    }
}
