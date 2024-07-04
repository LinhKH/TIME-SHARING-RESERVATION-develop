<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class Pagination
{
    private int $totalPages;
    private int $perPage;
    private int $currentPage;

    /**
     * @param int $totalPages totalPages
     * @param int $perPage perPage
     * @param int $currentPage currentPage
     */
    public function __construct(
        int $totalPages,
        int $perPage,
        int $currentPage
    ) {
        $this->totalPages = $totalPages;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
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
