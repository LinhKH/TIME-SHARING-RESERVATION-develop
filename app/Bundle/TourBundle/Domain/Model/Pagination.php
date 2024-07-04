<?php


namespace App\Bundle\TourBundle\Domain\Model;


class Pagination
{
    /**
     * @var int
     */
    private int $totalPage;

    /**
     * @var int
     */
    private int $perPage;

    /**
     * @var int
     */
    private int $currentPage;

    /**
     * Pagination constructor.
     * @param int $totalPage
     * @param int $perPage
     * @param int $currentPage
     */
    public function __construct(
        int $totalPage,
        int $perPage,
        int $currentPage
    )
    {
        $this->totalPage = $totalPage;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPage(): int
    {
        return $this->totalPage;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

}
