<?php

namespace App\Bundle\Common\Application;

class PaginationResult
{
    /**
     * @var int
     */
    public int $totalPage;
    /**
     * @var int
     */
    public int $currentPage;
    /**
     * @var int
     */
    public int $perPage;

    /**
     * @param int $currentPage currentPage
     * @param int $perPage perPage
     * @param int $totalPage totalPage
     */
    public function __construct(
        int $totalPage,
        int $perPage,
        int $currentPage
    ) {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->totalPage = $totalPage;
    }
}
