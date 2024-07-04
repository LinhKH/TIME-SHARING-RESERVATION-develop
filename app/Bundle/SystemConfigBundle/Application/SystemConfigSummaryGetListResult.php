<?php


namespace App\Bundle\SystemConfigBundle\Application;


use App\Bundle\Common\Domain\Model\PaginationResult;

class SystemConfigSummaryGetListResult
{
    /**
     * @var PaginationResult
     */
    public PaginationResult $paginationResult;

    /**
     * @var array
     */
    public array $resultRentalCompilation;

    /**
     * SystemConfigSummaryGetListResult constructor.
     * @param PaginationResult $paginationResult
     * @param array $resultRentalCompilation
     */
    public function __construct(PaginationResult $paginationResult, array $resultRentalCompilation)
    {
        $this->paginationResult = $paginationResult;
        $this->resultRentalCompilation = $resultRentalCompilation;
    }
}
