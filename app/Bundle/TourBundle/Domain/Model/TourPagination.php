<?php


namespace App\Bundle\TourBundle\Domain\Model;


class TourPagination
{
    /**
     * @var int
     */
    private int $page;

    /**
     * TourPagination constructor.
     * @param int $page
     */
    public function __construct(int $page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
