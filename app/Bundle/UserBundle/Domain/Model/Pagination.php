<?php

namespace  App\Bundle\UserBundle\Domain\Model;

final class Pagination
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
     * @param int $totalPage totalPage
     * @param int $perPage perPage
     * @param int $currentPage currentPage
     */
    public function __construct(
        int $totalPage,
        int $perPage,
        int $currentPage
    ) {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->totalPage = $totalPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
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
