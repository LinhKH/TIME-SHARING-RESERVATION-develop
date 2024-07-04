<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigCsvExportByTargetDetail
{
    public int $shown;
    public string $target;
    public int $id;
    public string $field;
    public int $itemOrder;

    /**
     * @param int $id
     * @param string $target
     * @param string $field
     * @param int $itemOrder
     * @param int $shown
     */
    public function __construct(
        int $id,
        string $target,
        string $field,
        int $itemOrder,
        int $shown

    ){
        $this->itemOrder = $itemOrder;
        $this->field = $field;
        $this->id = $id;
        $this->target = $target;
        $this->shown = $shown;
    }
}
