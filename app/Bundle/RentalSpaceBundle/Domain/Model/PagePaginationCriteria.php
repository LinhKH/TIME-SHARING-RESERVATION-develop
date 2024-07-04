<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class PagePaginationCriteria
{
    private int $page;

    /**
     * @param int $page page
     */
    public function __construct(
        int $page
    ) {
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
