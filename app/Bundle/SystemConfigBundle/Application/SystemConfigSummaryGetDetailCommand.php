<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryGetDetailCommand
{
    /**
     * @var int
     */
    public int $rentalSpaceCompilationId;

    /**
     * SystemConfigSummaryGetDetailCommand constructor.
     * @param int $rentalSpaceCompilationId
     */
    public function __construct(int $rentalSpaceCompilationId)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
    }
}
