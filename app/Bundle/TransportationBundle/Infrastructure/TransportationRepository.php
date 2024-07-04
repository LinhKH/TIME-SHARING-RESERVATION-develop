<?php

namespace App\Bundle\TransportationBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\TransportationBundle\Domain\ITransportationRepository;
use App\Bundle\TransportationBundle\Domain\TransportationId;
use App\Bundle\TransportationBundle\Domain\TransportationSuggestInformation;
use App\Models\TransportationStation as ModelTransportationStation;
use App\Models\TransportationStationEav as ModelTransportationStationEav;

class TransportationRepository implements ITransportationRepository
{

    /**
     * Suggest Transportation
     *
     * @param string $nameTransportation
     * @return TransportationSuggestInformation[]
     * @throws InvalidArgumentException
     */
    public function findByNameTransportation(string $nameTransportation): array
    {
        // TODO: Implement findByNameTransportation() method.
        $filterDataTransportationStationEav = ModelTransportationStationEav::with(['transportationStation'])
            ->where('attribute', 'title__ja')
            ->where('value','LIKE','%'.$nameTransportation.'%')
            ->get()->toArray();

        $transportations = [];
        foreach ($filterDataTransportationStationEav as $value) {
                $route = ModelTransportationStation::BUS;
                if ($value['transportation_station']['train']) {
                    $route = ModelTransportationStation::TRAIN;
                }
                if ($value['transportation_station']['monorail']) {
                    $route = ModelTransportationStation::MONORAIL;
                }
                if ($value['transportation_station']['subway']) {
                    $route = ModelTransportationStation::SUBWAY;
                }
                if ($value['transportation_station']['trolleybus']) {
                    $route = ModelTransportationStation::TROLLEYBUS;
                }
                if ($value['transportation_station']['tram']) {
                    $route = ModelTransportationStation::TRAM;
                }
                $transportations[] = new TransportationSuggestInformation(
                    new TransportationId($value['transportation_station']['id']),
                    $value['value'],
                    $value['transportation_station']['ref'],
                    $route
                );
        }
        return $transportations;
    }
}
