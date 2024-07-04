<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentEventInformation
{
    private ?bool $rentalShoes;
    private ?bool $yogaMat;
    private ?bool $wallMirrored;
    private ?bool $DJ_Booth;
    private ?bool $drumSet;
    private ?bool $piano;
    private ?bool $showerRoom;
    private ?bool $fullLengthMirror;
    private ?bool $stage;


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

    /**
     * @return bool|null
     */
    public function getRentalShoes(): ?bool
    {
        return $this->rentalShoes;
    }

    /**
     * @return bool|null
     */
    public function getYogaMat(): ?bool
    {
        return $this->yogaMat;
    }

    /**
     * @return bool|null
     */
    public function getWallMirrored(): ?bool
    {
        return $this->wallMirrored;
    }

    /**
     * @return bool|null
     */
    public function getDJBooth(): ?bool
    {
        return $this->DJ_Booth;
    }

    /**
     * @return bool|null
     */
    public function getDrumSet(): ?bool
    {
        return $this->drumSet;
    }

    /**
     * @return bool|null
     */
    public function getPiano(): ?bool
    {
        return $this->piano;
    }

    /**
     * @return bool|null
     */
    public function getShowerRoom(): ?bool
    {
        return $this->showerRoom;
    }

    /**
     * @return bool|null
     */
    public function getFullLengthMirror(): ?bool
    {
        return $this->fullLengthMirror;
    }

    /**
     * @return bool|null
     */
    public function getStage(): ?bool
    {
        return $this->stage;
    }


}
