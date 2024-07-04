<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailTrackLinkResult
{
    public int $id;
    public int $rentalSpaceId;
    public string $trackingLinkName;
    public string $trackingLinkToSpaceTopPage;
    public string $trackingLinkToSpaceReservationPage;


    /**
     * @param int $id
     * @param int $rentalSpaceId
     * @param string $trackingLinkName
     * @param string $trackingLinkToSpaceTopPage
     * @param string $trackingLinkToSpaceReservationPage
     */
    public function __construct(
        int $id,
        int $rentalSpaceId,
        string $trackingLinkName,
        string $trackingLinkToSpaceTopPage,
        string $trackingLinkToSpaceReservationPage
    ){
        $this->trackingLinkToSpaceReservationPage = $trackingLinkToSpaceReservationPage;
        $this->trackingLinkToSpaceTopPage = $trackingLinkToSpaceTopPage;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->trackingLinkName = $trackingLinkName;
        $this->id = $id;
    }
}
