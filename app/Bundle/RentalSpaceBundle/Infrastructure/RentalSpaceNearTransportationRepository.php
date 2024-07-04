<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceNearTransportationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\NearTransportationInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TransportationBundle\Domain\TransportationId;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceNearbyStations as ModelRentalSpaceNearbyStations;
use App\Models\TransportationStation as ModelTransportationStation;
use App\Models\TransportationStationEav as ModelTransportationStationEav;

class RentalSpaceNearTransportationRepository implements IRentalSpaceNearTransportationRepository
{

    /**
     * Create Or Update Near Transportation
     * @param NearTransportationInformation[] $nearTransportation
     * @return RentalSpaceId|null
     */
    public function createOrUpdateNearTransportation(array $nearTransportation): ?RentalSpaceId
    {
        // TODO: Implement createOrUpdateNearTransportation() method.
        $rentalSpaceID = null;
        foreach ($nearTransportation as $transportation) {
            $transportationItem = ModelTransportationStation::find($transportation->getTransportationStationId()->getValue());
            $space = ModelRentalSpace::find($transportation->getRentalSpaceId()->getValue());
            if (!$transportationItem || !$space) {
                break;
            }
            $entity = ModelRentalSpaceNearbyStations::where('rental_space_id', $transportation->getRentalSpaceId()->getValue())
                ->where('transportation_station_id', $transportation->getTransportationStationId()->getValue())
                ->first();
            if ($entity) {
                $entity->update([
                    'walking_duration' => $transportation->getWalkingDuration(),
                    'transportation_station_id' => $transportation->getTransportationStationId()->getValue(),
                    'ref' => $transportation->getRef(),
                    'joined_stations' => $transportation->getTransportationStationId()->getValue()
                ]);
            } else {
                ModelRentalSpaceNearbyStations::create([
                    'rental_space_id' => $transportation->getRentalSpaceId()->getValue(),
                    'walking_duration' => $transportation->getWalkingDuration(),
                    'transportation_station_id' => $transportation->getTransportationStationId()->getValue(),
                    'ref' => $transportation->getRef(),
                    'joined_stations' => $transportation->getTransportationStationId()->getValue()
                ]);
            }
            $rentalSpaceID = $transportation->getRentalSpaceId();
        }

        return $rentalSpaceID;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return NearTransportationInformation[]
     * @throws InvalidArgumentException
     */
    public function findAllTransportationBySpaceId(RentalSpaceId $rentalSpaceId): array
    {
        // TODO: Implement findAllTransportationBySpaceId() method.
        $entities = ModelRentalSpaceNearbyStations::with(['transportationStation'])
            ->where('rental_space_id', $rentalSpaceId->getValue())
            ->get()->toArray();

        $transportationList = [];
        if (empty($entities)) {
            return $transportationList;
        }

        foreach ($entities as $entity) {
            $route = ModelTransportationStation::BUS;
            if ($entity['transportation_station']['train']) {
                $route = ModelTransportationStation::TRAIN;
            }
            if ($entity['transportation_station']['monorail']) {
                $route = ModelTransportationStation::MONORAIL;
            }
            if ($entity['transportation_station']['subway']) {
                $route = ModelTransportationStation::SUBWAY;
            }
            if ($entity['transportation_station']['trolleybus']) {
                $route = ModelTransportationStation::TROLLEYBUS;
            }
            if ($entity['transportation_station']['tram']) {
                $route = ModelTransportationStation::TRAM;
            }
            $dataTransportationStationEav = ModelTransportationStationEav::where('attribute', 'title__ja')
                ->where('namespace',$entity['transportation_station']['id'])
                ->first();
            $transportationList[] = new NearTransportationInformation(
                $rentalSpaceId,
                new TransportationId($entity['transportation_station']['id']),
                $entity['walking_duration'],
                $entity['ref'],
                $dataTransportationStationEav->value,
                $route,
                $entity['id']
            );
        }
        return $transportationList;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param TransportationId $nearTransportationId
     * @return RentalSpaceId
     */
    public function deleteNearTransportation(RentalSpaceId $rentalSpaceId, TransportationId $nearTransportationId): RentalSpaceId
    {
        // TODO: Implement deleteNearTransportation() method.
        ModelRentalSpaceNearbyStations::where('id', $nearTransportationId->getValue())
            ->where('rental_space_id', $rentalSpaceId->getValue())
            ->delete();
        return $rentalSpaceId;
    }
}
