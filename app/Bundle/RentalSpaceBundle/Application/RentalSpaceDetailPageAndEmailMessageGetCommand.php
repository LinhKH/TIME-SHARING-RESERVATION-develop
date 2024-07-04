<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDetailPageAndEmailMessageGetCommand
{
    /**
     * @var int
     */
    public int $pageAndEmailId;

    /**
     * @var int
     */
    public int $type;

    /**
     * RentalSpaceDetailPageAndEmailMessageGetCommand constructor.
     * @param int $pageAndEmailId
     * @param int $type
     */
    public function __construct(
        int $pageAndEmailId,
        int $type
    )
    {
        $this->pageAndEmailId = $pageAndEmailId;
        $this->type = $type;
    }
}
