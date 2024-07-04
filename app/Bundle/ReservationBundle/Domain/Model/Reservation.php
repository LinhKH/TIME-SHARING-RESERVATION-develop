<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class Reservation
{
    private ?ReservationId $reservationId;
    private ?ReservationPlanLess $reservationPlanLess;
    private ?ReservationBookingCalendar $reservationBookingCalendar;
    private RentalSpaceId $rentalSpaceId;
    private CustomerId $customerId;
    private ReservationStatusType $status;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param ReservationId|null $reservationId
     * @param CustomerId $customerId
     * @param ReservationPlanLess|null $reservationPlanLess
     * @param ReservationBookingCalendar|null $reservationBookingCalendar
     * @param ReservationStatusType $status
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        ?ReservationId $reservationId,
        CustomerId $customerId,
        ?ReservationPlanLess $reservationPlanLess,
        ?ReservationBookingCalendar $reservationBookingCalendar,
        ReservationStatusType $status
    ) {
        $this->customerId = $customerId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->reservationBookingCalendar = $reservationBookingCalendar;
        $this->reservationPlanLess = $reservationPlanLess;
        $this->reservationId = $reservationId;
        $this->status = $status;
    }

    /**
     * @return ReservationId|null
     */
    public function getReservationId(): ?ReservationId
    {
        return $this->reservationId;
    }

    /**
     * @return ReservationPlanLess|null
     */
    public function getReservationPlanLess(): ?ReservationPlanLess
    {
        return $this->reservationPlanLess;
    }

    /**
     * @return ReservationBookingCalendar|null
     */
    public function getReservationBookingCalendar(): ?ReservationBookingCalendar
    {
        return $this->reservationBookingCalendar;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return CustomerId
     */
    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    /**
     * @return ReservationStatusType
     */
    public function getStatus(): ReservationStatusType
    {
        return $this->status;
    }
}
