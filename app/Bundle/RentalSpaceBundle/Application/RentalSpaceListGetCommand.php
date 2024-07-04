<?php
namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceListGetCommand
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
