<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalOverrideDeleteResult
{
    public bool $isDelete;

    public function __construct(
        bool $isDelete
    ){
        $this->isDelete = $isDelete;
    }
}
