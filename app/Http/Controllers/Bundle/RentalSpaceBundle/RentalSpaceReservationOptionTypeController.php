<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailReservationOptionTypeApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailReservationOptionTypeCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostReservationOptionTypeApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostReservationOptionTypeCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceReservationOptionTypeObjectCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceReservationOptionTypeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalSpaceReservationOptionTypeController extends Controller
{
    /**
     * Create - Reservation Option Type
     */

    public function postReservationOptionType($rentalSpaceId, Request $request): JsonResponse
    {
        $rentalSpaceReservationOptionTypeRepository = new RentalSpaceReservationOptionTypeRepository();
        $postRentalSpacePostReservationOptionTypeApplicationService = new RentalSpacePostReservationOptionTypeApplicationService(
            $rentalSpaceReservationOptionTypeRepository
        );

        $reservationOptionTypes = [];
        if (!empty($request->reservation_option_types)) {
            foreach ($request->reservation_option_types as $reservationOptionType)
            {
                $priceWithFaction = $reservationOptionType['price'] ?? 0;
                $reservationOptionTypes[] = new RentalSpaceReservationOptionTypeObjectCommand(
                    $reservationOptionType['title_ja'] ?? null,
                    $reservationOptionType['description_ja'] ?? null,
                    $reservationOptionType['price'] ?? 0,
                    (int)$priceWithFaction * 100,
                    $reservationOptionType['unit_type'] ?? null,
                    $reservationOptionType['active'] ?? 0,
                    $reservationOptionType['order_number'] ?? 0,
                );
            }
        }

        $command = new RentalSpacePostReservationOptionTypeCommand(
            $rentalSpaceId,
            $reservationOptionTypes
        );
        $rentalSpace = $postRentalSpacePostReservationOptionTypeApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * GET - Detail Reservation Option Type
     * @throws RecordNotFoundException
     */
    public function detailReservationOptionType($rentalSpaceId): JsonResponse
    {
        $rentalSpaceReservationOptionTypeRepository = new RentalSpaceReservationOptionTypeRepository();
        $detailApplicationService = new RentalSpaceGetDetailReservationOptionTypeApplicationService(
            $rentalSpaceReservationOptionTypeRepository
        );

        $command = new RentalSpaceGetDetailReservationOptionTypeCommand($rentalSpaceId);
        try {
            $reservationOptionTypes = $detailApplicationService->handle($command);
        } catch (InvalidArgumentException|RecordNotFoundException $e) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        return response()->json(['status'=>200, 'data'=>$reservationOptionTypes]);
    }
}
