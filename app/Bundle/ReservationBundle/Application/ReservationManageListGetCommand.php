<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationManageListGetCommand
{
    public int $page;

    /**
     * @param int $page page
     */
    public function __construct(
        int $page
    ){
        $this->page = $page;
    }
}
