<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpacePutPageResult
{
    public int $pageId;

    /**
     * RentalSpacePutPageResult constructor.
     * @param int $pageId
     */
    public function __construct(int $pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }
}
