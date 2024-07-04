<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailEmailMessageResult
{
    public ?string $tomorrowsReminder;
    public ?string $reservationAfterPayment;
    public ?string $reservationCreation;
    public ?string $tourComplete;
    public RentalSpaceId $rentalSpaceId;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param string|null $reservationCreation
     * @param string|null $reservationAfterPayment
     * @param string|null $tomorrowsReminder
     * @param string|null $tourComplete
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        ?string $reservationCreation,
        ?string $reservationAfterPayment,
        ?string $tomorrowsReminder,
        ?string $tourComplete
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->reservationCreation = $reservationCreation;
        $this->reservationAfterPayment = $reservationAfterPayment;
        $this->tomorrowsReminder = $tomorrowsReminder;
        $this->tourComplete = $tourComplete;
    }
}
