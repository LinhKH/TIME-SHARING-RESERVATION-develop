<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class TrackingLinkInformation
{
    private TrackingLinkId $id;
    private RentalSpaceId $rentalSpaceId;
    private string $trackingLinkToSpaceTopPage;
    private string $trackingLinkToSpaceReservationPage;
    private string $trackingLinkName;

    /**
     * @param TrackingLinkId $id
     * @param RentalSpaceId $rentalSpaceId
     * @param string $trackingLinkName
     * @param string $trackingLinkToSpaceTopPage
     * @param string $trackingLinkToSpaceReservationPage
     */
    public function __construct(
        TrackingLinkId $id,
        RentalSpaceId $rentalSpaceId,
        string $trackingLinkName,
        string $trackingLinkToSpaceTopPage,
        string $trackingLinkToSpaceReservationPage
    ){
        $this->trackingLinkName = $trackingLinkName;
        $this->trackingLinkToSpaceReservationPage = $trackingLinkToSpaceReservationPage;
        $this->trackingLinkToSpaceTopPage = $trackingLinkToSpaceTopPage;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->id = $id;
    }

    /**
     * @return TrackingLinkId
     */
    public function getTrackingLinkId(): TrackingLinkId
    {
        return $this->id;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return string
     */
    public function getTrackingLinkName(): string
    {
        return $this->trackingLinkName;
    }

    /**
     * @return string
     */
    public function getTrackingLinkToSpaceTopPage(): string
    {
        return $this->trackingLinkToSpaceTopPage;
    }

    /**
     * @return string
     */
    public function getTrackingLinkToSpaceReservationPage(): string
    {
        return $this->trackingLinkToSpaceReservationPage;
    }

}
