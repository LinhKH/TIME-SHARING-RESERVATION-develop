<?php


namespace App\Bundle\TourBundle\Application;


final class TourListGetCommand
{
    /**
     * @var int
     */
    public int $page;

    /**
     * TourListGetCommand constructor.
     * @param int $page
     */
    public function __construct(
        int $page
    )
    {
        $this->page = $page;
    }
}
