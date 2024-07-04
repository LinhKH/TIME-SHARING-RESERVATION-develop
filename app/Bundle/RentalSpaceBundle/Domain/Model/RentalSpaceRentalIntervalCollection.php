<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalIntervalCollection
{

    private array $rentalIntervalDateAndTimes;

    /**
     * @param RentalIntervalDateAndTime[] $rentalIntervalDateAndTimes
     */
    public function __construct(
        array $rentalIntervalDateAndTimes
    ){
        $this->rentalIntervalDateAndTimes = $rentalIntervalDateAndTimes;
    }

    /**
     * @return RentalIntervalDateAndTime[]
     */
    public function getRentalIntervalDateAndTimes(): array
    {
        return $this->rentalIntervalDateAndTimes;
    }


    /**
     * @param RentalIntervalDateAndTime $request
     * @return bool
     */
    public function valid(RentalIntervalDateAndTime $request ): bool
    {
        foreach ($this->rentalIntervalDateAndTimes as $rentalInterval )
        {

            foreach ($request->getDays() as $day) {
                if ($rentalInterval->externalApplicabilityPeriod($day)) {
                    continue;
                }
                return false;
            }
        }
        return true;
    }
}
