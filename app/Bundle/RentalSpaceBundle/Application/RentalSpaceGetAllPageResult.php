<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceGetAllPageResult
{
    /**
     * @var int
     */
    public int $rentalSpaceId;

    /**
     * @var RentalSpacePageAndEmailMessageObjectResult[]|null
     */
    public ?array $pageResult;

    /**
     * RentalSpaceGetAllPageResult constructor.
     * @param int $rentalSpaceId
     * @param RentalSpacePageAndEmailMessageObjectResult[]|null $pageResult
     */
    public function __construct(
        int $rentalSpaceId,
        ?array $pageResult
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->pageResult = $pageResult;
    }
}
