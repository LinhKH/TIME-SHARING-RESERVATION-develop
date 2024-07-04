<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryDeleteImageResult
{
    /**
     * @var bool
     */
    public bool $isSuccess;

    /**
     * SystemConfigSummaryDeleteImageResult constructor.
     * @param bool $isSuccess
     */
    public function __construct(bool $isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }
}
