<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\RentalSpaceBundle\Application\NearTransportationDeleteApplicationService;
use App\Bundle\RentalSpaceBundle\Application\NearTransportationDeleteCommand;
use App\Bundle\RentalSpaceBundle\Application\NearTransportationGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\NearTransportationGetCommand;
use App\Bundle\RentalSpaceBundle\Application\NearTransportationPostApplicationService;
use App\Bundle\RentalSpaceBundle\Application\NearTransportationPostCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceNearTransportationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\NearTransportationRequest;
use Illuminate\Http\JsonResponse;

class NearTransportationController extends Controller
{
    /**
     * Add Or Update Near Transportation
     *
     * @param $rentalSpaceId
     * @param NearTransportationRequest $request
     * @return JsonResponse
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\TransactionException
     */
    public function addOrUpdateNearTransportation($rentalSpaceId, NearTransportationRequest $request): JsonResponse
    {
        $nearTransportationRepository = new RentalSpaceNearTransportationRepository();
        $applicationService = new NearTransportationPostApplicationService(
            $nearTransportationRepository
        );
        $command = [];
        foreach ($request['transportations'] as $transportation) {
            $command[] = new NearTransportationPostCommand(
                $rentalSpaceId,
                $transportation['transportation_station_id'] ?? null,
                $transportation['walking_duration'] ?? 0,
                $transportation['ref'] ?? null
            );
        }

        $nearTransportation = $applicationService->handle($command);
        if (empty($nearTransportation->rentalSpaceId)) {
            return response()->json([
                'status' => 401,
                'message' => "Create or Update Near By Transportation Fail. Please check again value of spaceID or transportationID !"
            ], 401);
        }
        return response()->json(['rental_space_id' => $nearTransportation->rentalSpaceId], 200);
    }

    /**
     * Get All Transportation by Space ID
     */
    public function getNearTransportation($rentalSpaceId): JsonResponse
    {
        $nearTransportationRepository = new RentalSpaceNearTransportationRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $applicationService = new NearTransportationGetApplicationService(
            $nearTransportationRepository,
            $rentalSpaceGeneralRepository
        );
        $command = new NearTransportationGetCommand($rentalSpaceId);

        $nearTransportation = $applicationService->handle($command);
        $response = [];

        foreach ($nearTransportation as $transportation) {
            $response[] = [
                'near_transportation_id' => $transportation->nearTransportationId,
                'transportation_id' => $transportation->transportationId,
                'transportation_name' => $transportation->transportationName,
                'ref' => $transportation->ref,
                'walking_duration' => $transportation->walkingDuration,
                'route' => $transportation->route
            ];
        }

        return response()->json([
            'rental_space_id' => (int)$rentalSpaceId,
            'near_transportations' => $response
        ], 200);
    }

    public function deleteNearTransportation($rentalSpaceId, $nearTransportationId): JsonResponse
    {
        $nearTransportationRepository = new RentalSpaceNearTransportationRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $applicationService = new NearTransportationDeleteApplicationService(
            $nearTransportationRepository,
            $rentalSpaceGeneralRepository
        );
        $command = new NearTransportationDeleteCommand(
            $rentalSpaceId,
            $nearTransportationId
        );
        $applicationService->handle($command);

        return response()->json([
            'rental_space_id' => (int)$rentalSpaceId,
        ], 200);
    }
}
