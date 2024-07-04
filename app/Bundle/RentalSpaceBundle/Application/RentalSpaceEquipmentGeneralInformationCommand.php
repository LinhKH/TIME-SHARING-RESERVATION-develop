<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentGeneralInformationCommand
{
    public string $wifi;
    public string $audioSpeaker;
    public string $monitor;
    public string $toilet;
    public ?bool $kitchen;
    public ?bool $refrigerator;
    public ?bool $freezer;
    public ?bool $iceMachine;
    public ?bool $airConditioner;
    public ?bool $elevator;
    public ?bool $tvSet;
    public ?bool $soundProofingEquipment;
    public ?bool $karaoke;
    public ?bool $microphone;
    public ?bool $projector;
    public ?bool $dvdPlayer;

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
}
