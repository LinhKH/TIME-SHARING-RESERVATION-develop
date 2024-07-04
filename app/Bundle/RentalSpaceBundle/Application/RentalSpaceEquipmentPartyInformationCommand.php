<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentPartyInformationCommand
{
    public ?bool $bbqStove;
    public ?bool $wineCellar;
    public ?bool $toaster;
    public ?bool $coffeeMaker;
    public ?bool $riceCooker;
    public ?bool $oven;
    public ?bool $microwave;
    public ?bool $grilledFish;
    public ?bool $fryingPan;
    public ?bool $pot;
    public ?bool $kitchenKnife;
    public ?string $stove;
    public ?string $cutlery;
    public ?string $chopsticks;
    public ?string $glass;
    public ?string $plate;
    public ?string $partGame;


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

}
