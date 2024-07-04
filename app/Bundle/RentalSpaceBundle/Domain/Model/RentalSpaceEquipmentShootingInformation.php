<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentShootingInformation
{
    private ?bool $barCounter;
    private ?bool $gardenOrLawn;
    private ?bool $bathtub;
    private ?bool $spiralStaircase;
    private ?bool $atrium;
    private ?bool $hearth;
    private ?bool $japaneseStyleRoom;
    private ?bool $balcony;
    private ?bool $veranda;
    private ?bool $rooftop;
    private ?bool $bullbackShooting;
    private ?bool $rHorizont;
    private ?bool $whiteHorizont;
    private ?bool $birdEyeViewShooting;
    private ?bool $ancillaryServices;
    private ?bool $reflector;
    private ?bool $tripod;
    private ?string $electricCapacity;
    private ?string $electricCapacityType;
    private ?bool $pool;
    private ?bool $terrace;
    private ?bool $lightingSpotlight;
    private ?bool $waitingRoomOrMakeupRoom;
    private ?bool $largeParkingLot;


    /**
     * Equipment Information : Shooting equipment
     *
     * @param bool|null $waitingRoomOrMakeupRoom
     * @param bool|null $lightingSpotlight
     * @param bool|null $terrace
     * @param bool|null $pool
     * @param string|null $electricCapacityType
     * @param string|null $electricCapacity
     * @param bool|null $largeParkingLot
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

    /**
     * @return bool|null
     */
    public function getLargeParkingLot(): ?bool
    {
        return $this->largeParkingLot;
    }

    /**
     * @return bool|null
     */
    public function getBarCounter(): ?bool
    {
        return $this->barCounter;
    }

    /**
     * @return bool|null
     */
    public function getGardenOrLawn(): ?bool
    {
        return $this->gardenOrLawn;
    }

    /**
     * @return bool|null
     */
    public function getBathtub(): ?bool
    {
        return $this->bathtub;
    }

    /**
     * @return bool|null
     */
    public function getSpiralStaircase(): ?bool
    {
        return $this->spiralStaircase;
    }

    /**
     * @return bool|null
     */
    public function getAtrium(): ?bool
    {
        return $this->atrium;
    }

    /**
     * @return bool|null
     */
    public function getHearth(): ?bool
    {
        return $this->hearth;
    }

    /**
     * @return bool|null
     */
    public function getJapaneseStyleRoom(): ?bool
    {
        return $this->japaneseStyleRoom;
    }

    /**
     * @return bool|null
     */
    public function getBalcony(): ?bool
    {
        return $this->balcony;
    }

    /**
     * @return bool|null
     */
    public function getVeranda(): ?bool
    {
        return $this->veranda;
    }

    /**
     * @return bool|null
     */
    public function getRooftop(): ?bool
    {
        return $this->rooftop;
    }

    /**
     * @return bool|null
     */
    public function getBullbackShooting(): ?bool
    {
        return $this->bullbackShooting;
    }

    /**
     * @return bool|null
     */
    public function getRHorizont(): ?bool
    {
        return $this->rHorizont;
    }

    /**
     * @return bool|null
     */
    public function getWhiteHorizont(): ?bool
    {
        return $this->whiteHorizont;
    }

    /**
     * @return bool|null
     */
    public function getBirdEyeViewShooting(): ?bool
    {
        return $this->birdEyeViewShooting;
    }

    /**
     * @return bool|null
     */
    public function getAncillaryServices(): ?bool
    {
        return $this->ancillaryServices;
    }

    /**
     * @return bool|null
     */
    public function getReflector(): ?bool
    {
        return $this->reflector;
    }

    /**
     * @return bool|null
     */
    public function getTripod(): ?bool
    {
        return $this->tripod;
    }

    /**
     * @return string|null
     */
    public function getElectricCapacity(): ?string
    {
        return $this->electricCapacity;
    }

    /**
     * @return string|null
     */
    public function getElectricCapacityType(): ?string
    {
        return $this->electricCapacityType;
    }

    /**
     * @return bool|null
     */
    public function getPool(): ?bool
    {
        return $this->pool;
    }

    /**
     * @return bool|null
     */
    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    /**
     * @return bool|null
     */
    public function getLightingSpotlight(): ?bool
    {
        return $this->lightingSpotlight;
    }

    /**
     * @return bool|null
     */
    public function getWaitingRoomOrMakeupRoom(): ?bool
    {
        return $this->waitingRoomOrMakeupRoom;
    }


}
