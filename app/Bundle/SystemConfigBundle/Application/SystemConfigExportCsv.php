<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigExportCsv
{
    public int $shown;
    public string $target;
    public int $id;

    /**
     * @param int $id
     * @param string $target
     * @param int $shown
     */
    public function __construct(
        int $id,
        string $target,
        int $shown

    ){
        $this->id = $id;
        $this->target = $target;
        $this->shown = $shown;
    }
}
