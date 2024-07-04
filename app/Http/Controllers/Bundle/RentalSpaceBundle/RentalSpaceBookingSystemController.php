<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Constants\CommonConst;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDetailBookingSystemAdvancedGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDetailBookingSystemAdvancedGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailBookingSystemApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailBookingSystemCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostBookingSystemAdvancedApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostBookingSystemAdvancedCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostBookingSystemApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostBookingSystemCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceBookingSystemAdvancedRequest;
use App\Http\Requests\RentalSpaceBookingSystemRequest;
use Illuminate\Http\JsonResponse;

class RentalSpaceBookingSystemController extends Controller
{
    /**
     * Booking System
     */
    public function postBookingSystem($rentalSpaceId, RentalSpaceBookingSystemRequest $request): JsonResponse
    {
        $rentalSpaceBookingSystemRepository = new RentalSpaceBookingSystemRepository();
        $postRentalSpaceRentalSpaceBookingSystemApplicationService = new RentalSpacePostBookingSystemApplicationService(
            $rentalSpaceBookingSystemRepository
        );
        if ($request['agreeing_to_terms'] != 1) {
            return response()->json([
                "message" => "予約システム利用規約は必須です。"
            ], 404);
        }
        $command = new RentalSpacePostBookingSystemCommand(
            $rentalSpaceId,
            (int) $request['agreeing_to_terms']
        );
        $rentalSpace = $postRentalSpaceRentalSpaceBookingSystemApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * Get Detail Rental Space - Booking System
     */
    public function detailRentalSpaceBookingSystem($rentalSpaceId): JsonResponse
    {
        $rentalSpaceBookingSystemRepository = new RentalSpaceBookingSystemRepository();
        $detailRentalSpaceBookingSystemApplicationService = new RentalSpaceGetDetailBookingSystemApplicationService(
            $rentalSpaceBookingSystemRepository
        );

        $command = new RentalSpaceGetDetailBookingSystemCommand($rentalSpaceId);
        $bookingSystem = $detailRentalSpaceBookingSystemApplicationService->handle($command);

        $response = [
            'agreeing_to_terms' => $bookingSystem->agreeingToTerms,
            'space_terms_of_use' => $bookingSystem->spaceTermsOfUse
        ];
        return response()->json(['status' => 200, 'data'=>$response]);
    }


    /**
     * Create Booking System Advanced
     */
    public function postBookingSystemAdvanced($rentalSpaceId, RentalSpaceBookingSystemAdvancedRequest $request): JsonResponse
    {
        $rentalSpaceBookingSystemRepository = new RentalSpaceBookingSystemRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $postRentalSpaceBookingSystemAdvancedApplicationService = new RentalSpacePostBookingSystemAdvancedApplicationService(
            $rentalSpaceBookingSystemRepository,
            $rentalSpaceGeneralRepository
        );

        $command = new RentalSpacePostBookingSystemAdvancedCommand(
            $rentalSpaceId,
            $request['enable_last_minute_discount'] ?? null,
            $request['last_minute_book_discount_days_before_count'] ?? null,
            $request['last_minute_book_discount_percentage'] ?? null,
        );
        $rentalSpace = $postRentalSpaceBookingSystemAdvancedApplicationService->handle($command);
        return response()->json([
            'message' => 'Success',
            'rental_space_id' => $rentalSpace->rentalSpaceId
        ], 200);
    }

    /**
     * Get Detail Rental Space - Booking System Advanced
     */
    public function detailRentalSpaceBookingSystemAdvanced($rentalSpaceId): JsonResponse
    {
        $rentalSpaceBookingSystemRepository = new RentalSpaceBookingSystemRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $detailRentalSpaceBookingSystemAdvancedApplicationService = new RentalSpaceDetailBookingSystemAdvancedGetApplicationService(
            $rentalSpaceBookingSystemRepository,
            $rentalSpaceGeneralRepository
        );

        $command = new RentalSpaceDetailBookingSystemAdvancedGetCommand($rentalSpaceId);
        $bookingSystem = $detailRentalSpaceBookingSystemAdvancedApplicationService->handle($command);

        $response = [
            'rental_space_id' => $rentalSpaceId,
            'enable_last_minute_discount' => $bookingSystem->enableLastMinuteDiscount,
            'last_minute_book_discount_days_before_count' => $bookingSystem->lastMinuteBookDiscountDaysBeforeCount,
            'last_minute_book_discount_percentage' => $bookingSystem->lastMinuteBookDiscountPercentage
        ];
        return response()->json(['status' => 200, 'data'=>$response]);
    }
}
