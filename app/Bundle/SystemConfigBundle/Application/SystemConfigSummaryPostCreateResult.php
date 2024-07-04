<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPostCreateResult
{
    public int $rentalSpaceCompilationId;

    /**
     * SystemConfigSummaryPostCreateResult constructor.
     * @param int $rentalSpaceCompilationId
     */
    public function __construct(int $rentalSpaceCompilationId)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
    }

}
