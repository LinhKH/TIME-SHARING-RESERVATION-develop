<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentShootingInformationCommand
{
    public ?bool $barCounter;
    public ?bool $gardenOrLawn;
    public ?bool $bathtub;
    public ?bool $spiralStaircase;
    public ?bool $atrium;
    public ?bool $hearth;
    public ?bool $japaneseStyleRoom;
    public ?bool $balcony;
    public ?bool $veranda;
    public ?bool $rooftop;
    public ?bool $bullbackShooting;
    public ?bool $rHorizont;
    public ?bool $whiteHorizont;
    public ?bool $birdEyeViewShooting;
    public ?bool $ancillaryServices;
    public ?bool $reflector;
    public ?bool $tripod;
    public ?string $electricCapacity;
    public ?string $electricCapacityType;
    public ?bool $pool;
    public ?bool $terrace;
    public ?bool $lightingSpotlight;
    public ?bool $waitingRoomOrMakeupRoom;
    public ?bool $largeParkingLot;


    /**
     * Equipment Information : Shooting equipment
     *
     * @param bool|null $waitingRoomOrMakeupRoom
     * @param bool|null $lightingSpotlight
     * @param bool|null $terrace
     * @param bool|null $pool
     * @param string|null $electricCapacityType
     * @param string|null $electricCapacity
     * @param bool|null $tripod
     * @param bool|null $reflector
     * @param bool|null $ancillaryServices
     * @param bool|null $birdEyeViewShooting
     * @param bool|null $whiteHorizont
     * @param bool|null $rHorizont
     * @param bool|null $bullbackShooting
     * @param bool|null $rooftop
     * @param bool|null $veranda
     * @param bool|null $balcony
     * @param bool|null $japaneseStyleRoom
     * @param bool|null $hearth
     * @param bool|null $atrium
     * @param bool|null $spiralStaircase
     * @param bool|null $bathtub
     * @param bool|null $gardenOrLawn
     * @param bool|null $barCounter
     */
    public function __construct(
        ?bool $waitingRoomOrMakeupRoom,
        ?bool $lightingSpotlight,
        ?bool $terrace,
        ?bool $pool,
        ?string $electricCapacityType,
        ?string $electricCapacity,
        ?bool $largeParkingLot,
        ?bool $tripod,
        ?bool $reflector,
        ?bool $ancillaryServices,
        ?bool $birdEyeViewShooting,
        ?bool $whiteHorizont,
        ?bool $rHorizont,
        ?bool $bullbackShooting,
        ?bool $rooftop,
        ?bool $veranda,
        ?bool $balcony,
        ?bool $japaneseStyleRoom,
        ?bool $hearth,
        ?bool $atrium,
        ?bool $spiralStaircase,
        ?bool $bathtub,
        ?bool $gardenOrLawn,
        ?bool $barCounter
    ){
        $this->largeParkingLot = $largeParkingLot;
        $this->waitingRoomOrMakeupRoom = $waitingRoomOrMakeupRoom;
        $this->lightingSpotlight = $lightingSpotlight;
        $this->terrace = $terrace;
        $this->pool = $pool;
        $this->electricCapacityType = $electricCapacityType;
        $this->electricCapacity = $electricCapacity;
        $this->tripod = $tripod;
        $this->reflector = $reflector;
        $this->ancillaryServices = $ancillaryServices;
        $this->birdEyeViewShooting = $birdEyeViewShooting;
        $this->whiteHorizont = $whiteHorizont;
        $this->rHorizont = $rHorizont;
        $this->bullbackShooting = $bullbackShooting;
        $this->rooftop = $rooftop;
        $this->veranda = $veranda;
        $this->balcony = $balcony;
        $this->japaneseStyleRoom = $japaneseStyleRoom;
        $this->hearth = $hearth;
        $this->atrium = $atrium;
        $this->spiralStaircase = $spiralStaircase;
        $this->bathtub = $bathtub;
        $this->gardenOrLawn = $gardenOrLawn;
        $this->barCounter = $barCounter;
    }
}
