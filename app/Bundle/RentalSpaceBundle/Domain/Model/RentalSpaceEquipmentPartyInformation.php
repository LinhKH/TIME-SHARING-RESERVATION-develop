<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentPartyInformation
{
    private ?bool $bbqStove;
    private ?bool $wineCellar;
    private ?bool $toaster;
    private ?bool $coffeeMaker;
    private ?bool $riceCooker;
    private ?bool $oven;
    private ?bool $microwave;
    private ?bool $grilledFish;
    private ?bool $fryingPan;
    private ?bool $pot;
    private ?bool $kitchenKnife;
    private ?string $stove;
    private ?string $cutlery;
    private ?string $chopsticks;
    private ?string $glass;
    private ?string $plate;
    private ?string $partGame;


    /**
     * Equipment Information : Party equipment
     *
     * @param string|null $partGame
     * @param string|null $plate
     * @param string|null $glass
     * @param string|null $chopsticks
     * @param string|null $cutlery
     * @param string|null $stove
     * @param bool|null $kitchenKnife
     * @param bool|null $pot
     * @param bool|null $fryingPan
     * @param bool|null $grilledFish
     * @param bool|null $microwave
     * @param bool|null $oven
     * @param bool|null $riceCooker
     * @param bool|null $coffeeMaker
     * @param bool|null $toaster
     * @param bool|null $wineCellar
     * @param bool|null $bbqStove
     */
    public function __construct(
        ?string $partGame,
        ?string $plate,
        ?string $glass,
        ?string $chopsticks,
        ?string $cutlery,
        ?string $stove,
        ?bool $kitchenKnife,
        ?bool $pot,
        ?bool $fryingPan,
        ?bool $grilledFish,
        ?bool $microwave,
        ?bool $oven,
        ?bool $riceCooker,
        ?bool $coffeeMaker,
        ?bool $toaster,
        ?bool $wineCellar,
        ?bool $bbqStove

    ){
        $this->partGame = $partGame;
        $this->plate = $plate;
        $this->glass = $glass;
        $this->chopsticks = $chopsticks;
        $this->cutlery = $cutlery;
        $this->stove = $stove;
        $this->kitchenKnife = $kitchenKnife;
        $this->pot = $pot;
        $this->fryingPan = $fryingPan;
        $this->grilledFish = $grilledFish;
        $this->microwave = $microwave;
        $this->oven = $oven;
        $this->riceCooker = $riceCooker;
        $this->coffeeMaker = $coffeeMaker;
        $this->toaster = $toaster;
        $this->wineCellar = $wineCellar;
        $this->bbqStove = $bbqStove;

    }

    /**
     * @return bool|null
     */
    public function getBBQStove(): ?bool
    {
        return $this->bbqStove;
    }

    /**
     * @return bool|null
     */
    public function getWineCellar(): ?bool
    {
        return $this->wineCellar;
    }

    /**
     * @return bool|null
     */
    public function getToaster(): ?bool
    {
        return $this->toaster;
    }

    /**
     * @return bool|null
     */
    public function getCoffeeMaker(): ?bool
    {
        return $this->coffeeMaker;
    }

    /**
     * @return bool|null
     */
    public function getRiceCooker(): ?bool
    {
        return $this->riceCooker;
    }

    /**
     * @return bool|null
     */
    public function getOven(): ?bool
    {
        return $this->oven;
    }

    /**
     * @return bool|null
     */
    public function getMicrowave(): ?bool
    {
        return $this->microwave;
    }

    /**
     * @return bool|null
     */
    public function getGrilledFish(): ?bool
    {
        return $this->grilledFish;
    }

    /**
     * @return bool|null
     */
    public function getFryingPan(): ?bool
    {
        return $this->fryingPan;
    }

    /**
     * @return bool|null
     */
    public function getPot(): ?bool
    {
        return $this->pot;
    }

    /**
     * @return bool|null
     */
    public function getKitchenKnife(): ?bool
    {
        return $this->kitchenKnife;
    }

    /**
     * @return string|null
     */
    public function getStove(): ?string
    {
        return $this->stove;
    }

    /**
     * @return string|null
     */
    public function getCutlery(): ?string
    {
        return $this->cutlery;
    }

    /**
     * @return string|null
     */
    public function getChopsticks(): ?string
    {
        return $this->chopsticks;
    }

    /**
     * @return string|null
     */
    public function getGlass(): ?string
    {
        return $this->glass;
    }

    /**
     * @return string|null
     */
    public function getPlate(): ?string
    {
        return $this->plate;
    }

    /**
     * @return string|null
     */
    public function getPartGame(): ?string
    {
        return $this->partGame;
    }

}
