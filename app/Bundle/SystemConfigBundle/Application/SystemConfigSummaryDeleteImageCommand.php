<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryDeleteImageCommand
{
    /**
     * @var string
     */
    public string $rentalSpaceCompilationImageId;

    /**
     * SystemConfigSummaryDeleteImageCommand constructor.
     * @param string $rentalSpaceCompilationImageId
     */
    public function __construct(string $rentalSpaceCompilationImageId)
    {
        $this->rentalSpaceCompilationImageId = $rentalSpaceCompilationImageId;
    }
}
