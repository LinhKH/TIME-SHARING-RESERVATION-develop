<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentEventInformationCommand
{
    public ?bool $rentalShoes;
    public ?bool $yogaMat;
    public ?bool $wallMirrored;
    public ?bool $DJ_Booth;
    public ?bool $drumSet;
    public ?bool $piano;
    public ?bool $showerRoom;
    public ?bool $fullLengthMirror;
    public ?bool $stage;


    /**
     * Equipment Information : Event equipment
     *
     * @param bool|null $stage
     * @param bool|null $fullLengthMirror
     * @param bool|null $showerRoom
     * @param bool|null $piano
     * @param bool|null $drumSet
     * @param bool|null $DJ_Booth
     * @param bool|null $wallMirrored
     * @param bool|null $yogaMat
     * @param bool|null $rentalShoes
     */
    public function __construct(
        ?bool $stage,
        ?bool $fullLengthMirror,
        ?bool $showerRoom,
        ?bool $piano,
        ?bool $drumSet,
        ?bool $DJ_Booth,
        ?bool $wallMirrored,
        ?bool $yogaMat,
        ?bool $rentalShoes
    ){
        $this->stage = $stage;
        $this->fullLengthMirror = $fullLengthMirror;
        $this->showerRoom = $showerRoom;
        $this->piano = $piano;
        $this->drumSet = $drumSet;
        $this->DJ_Booth = $DJ_Booth;
        $this->wallMirrored = $wallMirrored;
        $this->yogaMat = $yogaMat;
        $this->rentalShoes = $rentalShoes;

    }
}
