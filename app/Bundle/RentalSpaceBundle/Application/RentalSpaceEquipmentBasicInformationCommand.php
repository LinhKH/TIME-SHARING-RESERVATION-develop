<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentBasicInformationCommand
{
    public ?bool $bringingInFoodAndDrink;
    public ?string $smoking;
    public ?bool $parking;
    public ?string $numberOfParkingLot;
    public ?bool $neighborhoodPayParking;
    public ?string $distanceToPaidParking;
    public ?string $flowToUse;
    public ?bool $luggageStorageSupport;
    public ?string $takkyubinReceiptCorrespondence;
    public ?string $numberOfTable;
    public ?bool $previewSupport;
    public ?string $numberOfSofaSeat;
    public ?bool $commercialUse;
    public ?bool $accompaniedByPet;
    public ?bool $staffResident;
    public ?bool $affiliatedRestaurant;
    public ?bool $affiliatedParkingLot;
    public ?bool $barrierFree;
    public ?bool $peripheralConvenienceStore;
    public ?string $distanceToConvenienceStore;
    public ?bool $surroundingSupermarket;
    public ?string $distanceToTheSupermarket;
    public ?bool $beverageVendingMachine;
    public ?bool $tobaccoVendingMachine;
    public ?string $other;
    public ?string $numberOfChairs;

    /**
     * Command Equipment information : Basic Information
     *

     * @param bool|null $bringingInFoodAndDrink
     * @param string|null $smoking
     * @param bool|null $parking
     * @param string|null $numberOfParkingLot
     * @param bool|null $neighborhoodPayParking
     * @param string|null $distanceToPaidParking
     * @param string|null $flowToUse
     * @param bool|null $luggageStorageSupport
     * @param string|null $takkyubinReceiptCorrespondence
     * @param string|null $numberOfTable
     * @param string|null $numberOfChairs
     * @param string|null $numberOfSofaSeat
     * @param bool|null $previewSupport
     * @param bool|null $commercialUse
     * @param bool|null $accompaniedByPet
     * @param bool|null $staffResident
     * @param bool|null $affiliatedRestaurant
     * @param bool|null $affiliatedParkingLot
     * @param bool|null $barrierFree
     * @param bool|null $peripheralConvenienceStore
     * @param string|null $distanceToConvenienceStore
     * @param bool|null $surroundingSupermarket
     * @param string|null $distanceToTheSupermarket
     * @param bool|null $beverageVendingMachine
     * @param bool|null $tobaccoVendingMachine
     * @param string|null $other
     */
    public function __construct(

        ?bool $bringingInFoodAndDrink,
        ?string $smoking,
        ?bool $parking,
        ?string $numberOfParkingLot,
        ?bool $neighborhoodPayParking,
        ?string $distanceToPaidParking,
        ?string $flowToUse,
        ?bool $luggageStorageSupport,
        ?string $takkyubinReceiptCorrespondence,
        ?string $numberOfTable,
        ?string $numberOfChairs,
        ?string $numberOfSofaSeat,
        ?bool $previewSupport,
        ?bool $commercialUse,
        ?bool $accompaniedByPet,
        ?bool $staffResident,
        ?bool $affiliatedRestaurant,
        ?bool $affiliatedParkingLot,
        ?bool $barrierFree,
        ?bool $peripheralConvenienceStore,
        ?string $distanceToConvenienceStore,
        ?bool $surroundingSupermarket,
        ?string $distanceToTheSupermarket,
        ?bool $beverageVendingMachine,
        ?bool $tobaccoVendingMachine,
        ?string $other
    ){
        $this->numberOfChairs = $numberOfChairs;
        $this->other = $other;
        $this->tobaccoVendingMachine = $tobaccoVendingMachine;
        $this->beverageVendingMachine = $beverageVendingMachine;
        $this->distanceToTheSupermarket = $distanceToTheSupermarket;
        $this->surroundingSupermarket = $surroundingSupermarket;
        $this->distanceToConvenienceStore = $distanceToConvenienceStore;
        $this->peripheralConvenienceStore = $peripheralConvenienceStore;
        $this->barrierFree = $barrierFree;
        $this->affiliatedParkingLot = $affiliatedParkingLot;
        $this->affiliatedRestaurant = $affiliatedRestaurant;
        $this->staffResident = $staffResident;
        $this->accompaniedByPet = $accompaniedByPet;
        $this->commercialUse = $commercialUse;
        $this->numberOfSofaSeat = $numberOfSofaSeat;
        $this->previewSupport = $previewSupport;
        $this->numberOfTable = $numberOfTable;
        $this->takkyubinReceiptCorrespondence = $takkyubinReceiptCorrespondence;
        $this->luggageStorageSupport = $luggageStorageSupport;
        $this->flowToUse = $flowToUse;
        $this->distanceToPaidParking = $distanceToPaidParking;
        $this->neighborhoodPayParking = $neighborhoodPayParking;
        $this->numberOfParkingLot = $numberOfParkingLot;
        $this->parking = $parking;
        $this->smoking = $smoking;
        $this->bringingInFoodAndDrink = $bringingInFoodAndDrink;


    }
}
