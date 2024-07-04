<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceBookingSystemRepository
{
    /**
     * Create rental space Booking System
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpaceBookingSystem(RentalSpace $rentalSpace): array;

    /**
     * Find rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return array{RentalSpaceBookingSystem|string}|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * Create rental space Booking System Advanced
     * @param RentalSpaceBookingSystemAdvanced $bookingSystemAdvanced
     * @return RentalSpaceId
     */
    public function createRentalSpaceBookingSystemAdvanced(RentalSpaceBookingSystemAdvanced $bookingSystemAdvanced): RentalSpaceId;

    /**
     * Find booking system advanced by space ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceBookingSystemAdvanced|null
     */
    public function findBookingSystemAdvancesBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpaceBookingSystemAdvanced;
}
