<?php


namespace App\Bundle\SystemConfigBundle\Application;


final class SystemConfigSummaryPutUpdateResult
{
    /**
     * @var int
     */
    public int $rentalSpaceCompilationId;

    /**
     * SystemConfigSummaryPutUpdateResult constructor.
     * @param int $rentalSpaceCompilationId
     */
    public function __construct(int $rentalSpaceCompilationId)
    {
        $this->rentalSpaceCompilationId = $rentalSpaceCompilationId;
    }
}
