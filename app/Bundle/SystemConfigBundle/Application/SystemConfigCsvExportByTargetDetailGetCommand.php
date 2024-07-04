<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigCsvExportByTargetDetailGetCommand
{
    public string $target;

    /**
     * @param string $target
     */
    public function __construct(
        string $target
    ){
        $this->target = $target;
    }
}
