<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentGeneralInformation
{
    private string $wifi;
    private string $audioSpeaker;
    private string $monitor;
    private string $toilet;
    private ?bool $kitchen;
    private ?bool $refrigerator;
    private ?bool $freezer;
    private ?bool $iceMachine;
    private ?bool $airConditioner;
    private ?bool $elevator;
    private ?bool $tvSet;
    private ?bool $soundProofingEquipment;
    private ?bool $karaoke;
    private ?bool $microphone;
    private ?bool $projector;
    private ?bool $dvdPlayer;

    /**
     * Equipment Information : General Information
     *
     * @param string $wifi
     * @param string $audioSpeaker
     * @param string $monitor
     * @param string $toilet
     * @param bool|null $kitchen
     * @param bool|null $refrigerator
     * @param bool|null $freezer
     * @param bool|null $iceMachine
     * @param bool|null $airConditioner
     * @param bool|null $elevator
     * @param bool|null $tvSet
     * @param bool|null $soundProofingEquipment
     * @param bool|null $karaoke
     * @param bool|null $microphone
     * @param bool|null $dvdPlayer
     * @param bool|null $projector
     */

    public function __construct(
        string $wifi,
        string $audioSpeaker,
        string $monitor,
        string $toilet,
        ?bool $kitchen,
        ?bool $refrigerator,
        ?bool $freezer,
        ?bool $iceMachine,
        ?bool $airConditioner,
        ?bool $elevator,
        ?bool $tvSet,
        ?bool $soundProofingEquipment,
        ?bool $karaoke,
        ?bool $microphone,
        ?bool $dvdPlayer,
        ?bool $projector
    ){
        $this->dvdPlayer = $dvdPlayer;
        $this->projector = $projector;
        $this->microphone = $microphone;
        $this->karaoke = $karaoke;
        $this->soundProofingEquipment = $soundProofingEquipment;
        $this->tvSet = $tvSet;
        $this->elevator = $elevator;
        $this->airConditioner = $airConditioner;
        $this->iceMachine = $iceMachine;
        $this->freezer = $freezer;
        $this->refrigerator = $refrigerator;
        $this->kitchen = $kitchen;
        $this->toilet = $toilet;
        $this->monitor = $monitor;
        $this->audioSpeaker = $audioSpeaker;
        $this->wifi = $wifi;
    }

    /**
     * @return string
     */
    public function getWifi(): string
    {
        return $this->wifi;
    }

    /**
     * @return string
     */
    public function getAudioSpeaker(): string
    {
        return $this->audioSpeaker;
    }

    /**
     * @return string
     */
    public function getMonitor(): string
    {
        return $this->monitor;
    }

    /**
     * @return string
     */
    public function getToilet(): string
    {
        return $this->toilet;
    }

    /**
     * @return bool|null
     */
    public function getKitchen(): ?bool
    {
        return $this->kitchen;
    }

    /**
     * @return bool|null
     */
    public function getRefrigerator(): ?bool
    {
        return $this->refrigerator;
    }

    /**
     * @return bool|null
     */
    public function getFreezer(): ?bool
    {
        return $this->freezer;
    }

    /**
     * @return bool|null
     */
    public function getIceMachine(): ?bool
    {
        return $this->iceMachine;
    }

    /**
     * @return bool|null
     */
    public function getAirConditioner(): ?bool
    {
        return $this->airConditioner;
    }

    /**
     * @return bool|null
     */
    public function getElevator(): ?bool
    {
        return $this->elevator;
    }

    /**
     * @return bool|null
     */
    public function getTvSet(): ?bool
    {
        return $this->tvSet;
    }

    /**
     * @return bool|null
     */
    public function getSoundProofingEquipment(): ?bool
    {
        return $this->soundProofingEquipment;
    }

    /**
     * @return bool|null
     */
    public function getKaraoke(): ?bool
    {
        return $this->karaoke;
    }

    /**
     * @return bool|null
     */
    public function getMicrophone(): ?bool
    {
        return $this->microphone;
    }

    /**
     * @return bool|null
     */
    public function getProjector(): ?bool
    {
        return $this->projector;
    }

    /**
     * @return bool|null
     */
    public function getDVDPlayer(): ?bool
    {
        return $this->dvdPlayer;
    }
}
