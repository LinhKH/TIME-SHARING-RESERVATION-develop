<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryPutUpdateImageCommand
{
    /**
     * @var string
     */
    public string $rentalSpaceCompilationImageId;

    /**
     * @var int
     */
    public int $type;

    /**
     * SystemConfigSummaryPutUpdateImageCommand constructor.
     * @param string $rentalSpaceCompilationImageId
     * @param int $type
     */
    public function __construct(string $rentalSpaceCompilationImageId, int $type)
    {
        $this->rentalSpaceCompilationImageId = $rentalSpaceCompilationImageId;
        $this->type = $type;
    }
}
