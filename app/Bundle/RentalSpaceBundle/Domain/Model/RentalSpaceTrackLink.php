<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceTrackLink
{
    private RentalSpaceId $rentalSpaceId;
    private TrackLinkType $type;
    private string $name;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param string $name
     * @param TrackLinkType $type
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        string $name,
        TrackLinkType $type
    ){
        $this->name = $name;
        $this->type = $type;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return TrackLinkType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
