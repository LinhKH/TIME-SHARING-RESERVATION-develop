<?php
namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\PaginationResult;

final class RentalSpaceListGetResult
{
    public PaginationResult $pagination;
    public array $rentalSpaces;

    /**
     * @param PaginationResult $pagination
     * @param RentalSpaceListResult[] $rentalSpaces rentalSpaces
     */
    public function __construct(
        PaginationResult $pagination,
        array $rentalSpaces

    ) {
        $this->pagination = $pagination;
        $this->rentalSpaces = $rentalSpaces;
    }
}
