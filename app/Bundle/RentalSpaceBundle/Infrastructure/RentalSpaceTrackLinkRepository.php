<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Constants\CommonConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceTrackLinkRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceTrackLink;
use App\Bundle\RentalSpaceBundle\Domain\Model\TrackingLinkId;
use App\Bundle\RentalSpaceBundle\Domain\Model\TrackingLinkInformation;
use App\Models\RentalSpace as RentalSpaceModel;
use App\Models\RentalSpaceEav as RentalSpaceEavModel;
use App\Models\TrackingLink;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class RentalSpaceTrackLinkRepository implements IRentalSpaceTrackLinkRepository
{


    /**
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function createRentalSpaceTrackLink(RentalSpaceTrackLink $rentalSpaceTrackLink): RentalSpaceTrackLink
    {
        // TODO: Implement createRentalSpaceTrackLink() method.
        $entity = TrackingLink::create([
            'entity_id' => $rentalSpaceTrackLink->getRentalSpaceId()->getValue(),
            'name' => $rentalSpaceTrackLink->getName(),
            'tracking_code' => $this->generateTrackingCode(),
            'type' => $rentalSpaceTrackLink->getType()->getValue()
        ]);

        return new RentalSpaceTrackLink(
            new RentalSpaceId($entity->entity_id),
            $rentalSpaceTrackLink->getName(),
            $rentalSpaceTrackLink->getType()
        );
    }

    public function generateTrackingCode($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return TrackingLinkInformation[]|null
     * @throws InvalidArgumentException
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array
    {
        $spaces = RentalSpaceModel::find($rentalSpaceId->getValue());
        if (!$spaces) {
            return null;
        }
        $spaceEavs = RentalSpaceEavModel::where('namespace', $rentalSpaceId->getValue())->get()->toArray();
        $entities = TrackingLink::where('entity_id', $rentalSpaceId->getValue())->get()->toArray();
        if (!$entities) {
            return null;
        }
        $spaceName = null;
        if (!empty($spaceEavs)) {
            foreach ($spaceEavs as $spaceEav) {
                if ($spaceEav['attribute'] === CommonConst::TITLE_JA) {
                    $spaceName = $spaceEav['value'];
                }
            }
        }

        $slugOfSpace = !empty($spaceName) ? str_replace(' ', '-', $spaceName) : $spaceName;

        $trackingLinks = [];
        foreach ($entities as $entity) {
            $trackingLinks[] = new TrackingLinkInformation(
                new TrackingLinkId($entity['id']),
                new RentalSpaceId($entity['entity_id']),
                $entity['name'],
                route('tracking.top_page', [$rentalSpaceId->getValue(), $slugOfSpace, $entity['tracking_code']]),
                route('tracking.reservation_page', [$rentalSpaceId->getValue(), $slugOfSpace, $entity['tracking_code']])
            );
        }
        return $trackingLinks;
    }

    public function updateNameTrackLinkById($nameTrackLink, $trackLinkId)
    {
        $sql = TrackingLink::findOrFail($trackLinkId);
        try {
            return $sql->update(['name' => $nameTrackLink]);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}
