<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceAllDetailEmailMessageGetResult
{
    /**
     * @var int
     */
    public int $rentalSpaceId;

    /**
     * @var array|null
     */
    public ?array $emailMessageResult;

    /**
     * RentalSpaceAllDetailEmailMessageGetResult constructor.
     * @param int $rentalSpaceId
     * @param RentalSpacePageAndEmailMessageObjectResult[]|null $emailMessageResult
     */
    public function __construct(
        int $rentalSpaceId,
        ?array $emailMessageResult
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->emailMessageResult = $emailMessageResult;
    }
}
