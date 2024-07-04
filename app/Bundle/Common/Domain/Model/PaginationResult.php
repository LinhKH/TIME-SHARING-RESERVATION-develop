<?php

namespace  App\Bundle\Common\Domain\Model;

final class PaginationResult
{
    public int $totalPage;
    public int $perPage;
    public int $currentPage;

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
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->totalPage = $totalPage;
    }
}
