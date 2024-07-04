<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\TourBundle\Domain\Model\RentalSpaceResult;

final class TourGetManageSettingResult
{
    /**
     * @var RentalSpaceResult[]|null
     */
    public ?array $rentalSpaces;

    /**
     * TourGetManageSettingResult constructor.
     * @param array $rentalSpaces
     */
    public function __construct(array $rentalSpaces)
    {
        $this->rentalSpaces = $rentalSpaces;
    }
}
