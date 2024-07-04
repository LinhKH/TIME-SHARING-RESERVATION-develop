<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryDeleteCommand
{
    public int $rentalSpaceCompilationId;

    /**
     * SystemConfigSummaryDeleteCommand constructor.
     * @param int $rentalSpaceCompilationId
     */
    public function __construct(int $rentalSpaceCompilationId)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
    }

}
