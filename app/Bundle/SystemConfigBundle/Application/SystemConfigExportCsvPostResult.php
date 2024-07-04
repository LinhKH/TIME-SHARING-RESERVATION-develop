<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigExportCsvPostResult
{
    public bool $isUpdated;

    /**
     * @param bool $isUpdated
     */
    public function __construct(
        bool $isUpdated
    ){
        $this->isUpdated = $isUpdated;
    }
}
