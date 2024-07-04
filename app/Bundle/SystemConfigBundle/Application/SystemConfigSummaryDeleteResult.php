<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigSummaryDeleteResult
{
    /**
     * @var bool
     */
    public bool $isSuccess;

    /**
     * SystemConfigSummaryDeleteResult constructor.
     * @param bool $isSuccess
     */
    public function __construct(
        bool $isSuccess
    )
    {
        $this->isSuccess = $isSuccess;
    }
}
