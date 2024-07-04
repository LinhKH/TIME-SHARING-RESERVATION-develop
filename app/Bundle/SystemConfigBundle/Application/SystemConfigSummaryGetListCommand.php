<?php

namespace App\Bundle\SystemConfigBundle\Application;

class SystemConfigSummaryGetListCommand
{
    /**
     * @var int
     */
    public int $page;

    /**
     * SystemConfigSummaryGetListCommand constructor.
     * @param int $page
     */
    public function __construct(int $page)
    {
        $this->page = $page;
    }
}
