<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpacePutEmailMessageResult
{
    /**
     * @var int
     */
    public int $emailMessageId;

    /**
     * RentalSpacePutEmailMessageResult constructor.
     * @param int $emailMessageId
     */
    public function __construct(int $emailMessageId)
    {
        $this->emailMessageId = $emailMessageId;
    }
}
