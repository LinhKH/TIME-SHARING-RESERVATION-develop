<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailTrackLinkApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailTrackLinkCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostTrackLinkApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostTrackLinkCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceTrackLinkRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceTrackLinkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class RentalSpaceTrackLinkController extends Controller
{

    /**
     * Rental Space Track Link
     */

    public function postRentalSpaceTrackLink($rentalSpaceId, RentalSpaceTrackLinkRequest $request): JsonResponse
    {
        $rentalSpaceTrackLinkRepository = new RentalSpaceTrackLinkRepository();

        $applicationService = new RentalSpacePostTrackLinkApplicationService(
            $rentalSpaceTrackLinkRepository
        );

        $command = new RentalSpacePostTrackLinkCommand(
            $rentalSpaceId,
            $request['name'],
            $request['type']
        );
        $rentalSpaceTrackLink = $applicationService->handle($command);
        return response()->json([
            'rental_space_id' => $rentalSpaceTrackLink->rentalSpaceId,
            'name' => $rentalSpaceTrackLink->name,
            'type' => $rentalSpaceTrackLink->type
        ]);
    }

    /**
     * Detail Track Link
     */
    public function detailRentalSpaceTrackLink($rentalSpaceId): JsonResponse
    {
        $rentalSpaceTrackLinkRepository = new RentalSpaceTrackLinkRepository();

        $applicationService = new RentalSpaceGetDetailTrackLinkApplicationService(
            $rentalSpaceTrackLinkRepository
        );

        $command = new RentalSpaceGetDetailTrackLinkCommand($rentalSpaceId);
        $trackLinks = $applicationService->handle($command);
        $response = [];

        foreach ($trackLinks as $trackLink) {
            $response[] = [
                'id' => $trackLink->id,
                'rental_space_id' => $trackLink->rentalSpaceId,
                'tracking_link_name' => $trackLink->trackingLinkName,
                'tracking_link_to_space_top_page' => $trackLink->trackingLinkToSpaceTopPage,
                'tracking_link_to_space_reservation_page' => $trackLink->trackingLinkToSpaceReservationPage
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Detail Track Link by Id
     */
    public function detailRentalSpaceTrackLinkById($rentalSpaceId, $trackLinkId): JsonResponse
    {
        $rentalSpaceTrackLinkRepository = new RentalSpaceTrackLinkRepository();

        $applicationService = new RentalSpaceGetDetailTrackLinkApplicationService(
            $rentalSpaceTrackLinkRepository
        );

        $command = new RentalSpaceGetDetailTrackLinkCommand($rentalSpaceId);
        $trackLinks = $applicationService->handle($command);
        $response = [];

        $detailRentalSpaceTrackLinkById = [];
        foreach ($trackLinks as $trackLink) {

            if ($trackLink->id == $trackLinkId) {
                $response = [
                    'id' => $trackLink->id,
                    'rental_space_id' => $trackLink->rentalSpaceId,
                    'tracking_link_name' => $trackLink->trackingLinkName,
                    'tracking_link_to_space_top_page' => $trackLink->trackingLinkToSpaceTopPage,
                    'tracking_link_to_space_reservation_page' => $trackLink->trackingLinkToSpaceReservationPage
                ];

                $detailRentalSpaceTrackLinkById = $response;
            }
        }

        return response()->json(['status' => 200, 'data' => $detailRentalSpaceTrackLinkById]);
    }

    public function updateNameTrackLinkById(Request $request, $trackLinkId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rentalSpaceTrackLinkRepository = new RentalSpaceTrackLinkRepository();
        $response = $rentalSpaceTrackLinkRepository->updateNameTrackLinkById($request->name, $trackLinkId);

        return response()->json(['status' => 200, 'data' => $response]);
    }
}
