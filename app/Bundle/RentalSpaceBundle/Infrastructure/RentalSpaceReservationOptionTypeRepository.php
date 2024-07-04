<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceReservationOptionTypeRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceReservationOptionTypes;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\ReservationOptionTypeReservationOptionType as ModelReservationOptionType;
use App\Models\ReservationOptionTypeReservationOptionTypeEav as ModelReservationOptionTypeEav;
use InvalidArgumentException;

class RentalSpaceReservationOptionTypeRepository implements IRentalSpaceReservationOptionTypeRepository
{

    /**
     * Create reservation option type
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     * @throws InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function createRentalSpaceReservationOptionType(RentalSpace $rentalSpace): array
    {
        $rentalSpaceId = $rentalSpace->getRentalSpaceReservationOptionTypes()->getRentalSpaceId()->getValue();

        $reservationOptionTypeId = ModelReservationOptionType::where('rental_space_id', $rentalSpaceId)->pluck('id')->toArray();
        ModelReservationOptionTypeEav::whereIn('namespace', $reservationOptionTypeId)->delete();

        ModelReservationOptionType::where('rental_space_id', $rentalSpace->getRentalSpaceReservationOptionTypes()->getRentalSpaceId()->getValue())->delete();
        // TODO: Implement createRentalSpaceBookingSystem() method.
        $reservationOptionTypes = [];
        foreach ($rentalSpace->getRentalSpaceReservationOptionTypes()->getReservationOptionTypes() as $reservationOptionType) {
            $reservationOptionData = ModelReservationOptionType::create([
                'order_number' => $reservationOptionType->getOrderNumber(),
                'active' => $reservationOptionType->getActive(),
                'maximum_order_quantity' => 0,
                'minimum_order_quantity' => 0,
                'rental_space_id' => $rentalSpace->getRentalSpaceReservationOptionTypes()->getRentalSpaceId()->getValue()
            ]);
            $reservationOptionTypes[] = [
                'reservationOptionTypeId' => $reservationOptionData->id,
                'title__ja' => $reservationOptionType->getTitleJa(),
                'description__ja' => $reservationOptionType->getDescriptionJa(),
                'price' => $reservationOptionType->getPrice(),
                'price_with_fraction' => $reservationOptionType->getPriceWithFraction(),
                'unitType' => $reservationOptionType->getUnitType(),
                'creationTime' => time(),
            ];
        }

        foreach ($reservationOptionTypes as $reservationOptionTypeEav) {
            if (!array_key_exists("reservationOptionTypeId", $reservationOptionTypeEav)) {
                continue;
            }
            $reservationOptionTypeId = $reservationOptionTypeEav['reservationOptionTypeId'];
            unset($reservationOptionTypeEav['reservationOptionTypeId']);

            foreach ($reservationOptionTypeEav as $key => $value) {
                if ($value === null) {
                    unset($reservationOptionTypeEav[$key]);
                } else {
                    ModelReservationOptionTypeEav::create([
                        'namespace' => $reservationOptionTypeId,
                        'attribute' => $key,
                        'value' => $value
                    ]);
                }
            }
        }
        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();

        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?array
    {
        $entities = ModelReservationOptionType::where('rental_space_id', $rentalSpaceId->getValue())->with('reservationOptionTypeEav')->get()->toArray();
        if (!$entities) {
            return null;
        }

        $reservationOptionTypes = [];
        foreach ($entities as $entity) {
            $optionTypeObject = [];
            $optionTypeObject['id'] = $entity['id'];
            $optionTypeObject['active'] = $entity['active'];
            $optionTypeObject['order_number'] = $entity['order_number'];
            foreach ($entity['reservation_option_type_eav'] as $eav) {
                $optionTypeObject[$eav['attribute']] = $eav['value'];
            }
            $reservationOptionTypes[] = $optionTypeObject;
        }

        return $reservationOptionTypes;
    }
}
