<?php

namespace App\Bundle\TourBundle\Application;

final class TourPutUpdateSettingCommand
{
    /**
     * @var string
     */
    public string $rentalSpaceIds;
    /**
     * @var int|null
     */
    public ?int $organizationId;

    /**
     * TourPutUpdateSettingCommand constructor.
     * @param string $rentalSpaceIds
     * @param int|null $organizationId
     */
    public function __construct(string $rentalSpaceIds, ?int $organizationId)
    {
        $this->rentalSpaceIds = $rentalSpaceIds;
        $this->organizationId = $organizationId;
    }
}
