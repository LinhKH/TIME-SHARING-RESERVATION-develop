<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentBasicInformation
{
    private ?bool $bringingInFoodAndDrink;
    private ?string $smoking;
    private ?bool $parking;
    private ?string $numberOfParkingLot;
    private ?bool $neighborhoodPayParking;
    private ?string $distanceToPaidParking;
    private ?string $flowToUse;
    private ?bool $luggageStorageSupport;
    private ?string $takkyubinReceiptCorrespondence;
    private ?string $numberOfTable;
    private ?bool $previewSupport;
    private ?string $numberOfSofaSeat;
    private ?bool $commercialUse;
    private ?bool $accompaniedByPet;
    private ?bool $staffResident;
    private ?bool $affiliatedRestaurant;
    private ?bool $affiliatedParkingLot;
    private ?bool $barrierFree;
    private ?bool $peripheralConvenienceStore;
    private ?string $distanceToConvenienceStore;
    private ?bool $surroundingSupermarket;
    private ?string $distanceToTheSupermarket;
    private ?bool $beverageVendingMachine;
    private ?bool $tobaccoVendingMachine;
    private ?string $other;
    private ?string $numberOfChairs;

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

    /**
     * @return bool|null
     */
    public function getBringingInFoodAndDrink(): ?bool
    {
        return $this->bringingInFoodAndDrink;
    }

    /**
     * @return string|null
     */
    public function getSmoking(): ?string
    {
        return $this->smoking;
    }

    /**
     * @return bool|null
     */
    public function getParking(): ?bool
    {
        return $this->parking;
    }

    /**
     * @return string|null
     */
    public function getNumberOfParkingLot(): ?string
    {
        return $this->numberOfParkingLot;
    }

    /**
     * @return bool|null
     */
    public function getNeighborhoodPayParking(): ?bool
    {
        return $this->neighborhoodPayParking;
    }

    /**
     * @return string|null
     */
    public function getDistanceToPaidParking(): ?string
    {
        return $this->distanceToPaidParking;
    }

    /**
     * @return string|null
     */
    public function getFlowToUse(): ?string
    {
        return $this->flowToUse;
    }

    /**
     * @return bool|null
     */
    public function getLuggageStorageSupport(): ?bool
    {
        return $this->luggageStorageSupport;
    }

    /**
     * @return string|null
     */
    public function getTakkyubinReceiptCorrespondence(): ?string
    {
        return $this->takkyubinReceiptCorrespondence;
    }

    /**
     * @return string|null
     */
    public function getNumberOfTable(): ?string
    {
        return $this->numberOfTable;
    }

    /**
     * @return bool|null
     */
    public function getPreviewSupport(): ?bool
    {
        return $this->previewSupport;
    }

    /**
     * @return string|null
     */
    public function getNumberOfSofaSeat(): ?string
    {
        return $this->numberOfSofaSeat;
    }

    /**
     * @return bool|null
     */
    public function getCommercialUse(): ?bool
    {
        return $this->commercialUse;
    }

    /**
     * @return bool|null
     */
    public function getAccompaniedByPet(): ?bool
    {
        return $this->accompaniedByPet;
    }

    /**
     * @return bool|null
     */
    public function getStaffResident(): ?bool
    {
        return $this->staffResident;
    }

    /**
     * @return bool|null
     */
    public function getAffiliatedRestaurant(): ?bool
    {
        return $this->affiliatedRestaurant;
    }

    /**
     * @return bool|null
     */
    public function getAffiliatedParkingLot(): ?bool
    {
        return $this->affiliatedParkingLot;
    }

    /**
     * @return bool|null
     */
    public function getBarrierFree(): ?bool
    {
        return $this->barrierFree;
    }

    /**
     * @return bool|null
     */
    public function getPeripheralConvenienceStore(): ?bool
    {
        return $this->peripheralConvenienceStore;
    }

    /**
     * @return string|null
     */
    public function getDistanceToConvenienceStore(): ?string
    {
        return $this->distanceToConvenienceStore;
    }

    /**
     * @return bool|null
     */
    public function getSurroundingSupermarket(): ?bool
    {
        return $this->surroundingSupermarket;
    }

    /**
     * @return string|null
     */
    public function getDistanceToTheSupermarket(): ?string
    {
        return $this->distanceToTheSupermarket;
    }

    /**
     * @return bool|null
     */
    public function getBeverageVendingMachine(): ?bool
    {
        return $this->beverageVendingMachine;
    }

    /**
     * @return bool|null
     */
    public function getTobaccoVendingMachine(): ?bool
    {
        return $this->tobaccoVendingMachine;
    }

    /**
     * @return string|null
     */
    public function getOther(): ?string
    {
        return $this->other;
    }

    /**
     * @return string|null
     */
    public function getNumberOfChairs(): ?string
    {
        return $this->numberOfChairs;
    }

}
