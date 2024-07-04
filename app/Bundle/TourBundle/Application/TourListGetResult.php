<?php


namespace App\Bundle\TourBundle\Application;


use App\Bundle\Common\Domain\Model\PaginationResult;

final class TourListGetResult
{
    /**
     * @var PaginationResult
     */
    public PaginationResult $paginationResult;
    /**
     * @var array
     */
    public array $resultTours;

    /**
     * TourListGetResult constructor.
     * @param PaginationResult $paginationResult
     * @param array $resultTours
     */
    public function __construct(
        PaginationResult $paginationResult,
        array $resultTours
    )
    {
        $this->paginationResult = $paginationResult;
        $this->resultTours = $resultTours;
    }
}
