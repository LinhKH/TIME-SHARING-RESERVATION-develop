<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceIntervalDeleteResult
{
    public bool $isDelete;

    /**
     * @param bool $isDelete
     */
    public function __construct(
        bool $isDelete
    ){
        $this->isDelete = $isDelete;
    }
}
