<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalDetailByIdGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalDetailByIdGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOfPlanInThisDayGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOfPlanInThisDayGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOverrideDelete;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOverrideDeleteApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOverrideDeleteCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOverrideOfPlanInThisDayGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalOverrideOfPlanInThisDayGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalSlotOverride;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalSlotOverrideUpdatePutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalIntervalSlotOverrideUpdatePutCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailRentalSpaceIntervalApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailRentalSpaceIntervalCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceIntervalDeleteApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceIntervalDeleteCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostRentalIntervalApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostRentalIntervalCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostRentalPlanApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalIntervalDetailByPlanIdGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalIntervalDetailByPlanIdGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalIntervalPutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalIntervalPutCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalPlanRepository;
use App\Http\Controllers\Bundle\ReservationBundle\ReservationController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalIntervalInThisDayRequest;
use App\Http\Requests\RentalSpaceRentalIntervalRequest;
use App\Http\Requests\RentalSpaceRentalIntervalUpdateRequest;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RentalSpaceRentalIntervalController extends Controller
{
    /**
     * @throws InvalidArgumentException|TransactionException
     */
    public function postRentalPlanInterval($rentalSpaceId, $rentalPlanId, RentalSpaceRentalIntervalRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalSpacePostRentalIntervalApplicationService(
            $rentalSpaceRentalIntervalRepository
        );

        $command = new RentalSpacePostRentalIntervalCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $request['applicability_periods'],
            $request['holiday_applicability_type'],
            $request['interval_multi'],
            $request['start_time_formatted'],
            $request['end_time_formatted'],
            $request['tenancy_price'],
            $request['per_person_price'],
            $request['max_simultaneous_reservations'],
            $request['max_simultaneous_people']
        );
        $rentalSpace = $applicationService->handle($command);

        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * GET - GET ALL Plan with interval information
     * @throws RecordNotFoundException
     */
    public function detailRentalPlanAndIntervalBySpaceId($rentalSpaceId): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalSpaceGetDetailRentalSpaceIntervalApplicationService(
            $rentalSpaceRentalIntervalRepository
        );
        $command = new RentalSpaceGetDetailRentalSpaceIntervalCommand($rentalSpaceId);

        try {
            $rentalIntervals = $applicationService->handle($command);
        } catch (InvalidArgumentException | RecordNotFoundException $e) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $response = [];
        foreach ($rentalIntervals as $interval) {
            $rentalIntervalInformation = [];
            foreach ($interval->rentalSpaceRentalIntervalResult as $value) {
                $rentalIntervalInformation[] = [
                    'id' => $value->id,
                    'applicability_periods' => $value->applicabilityPeriods,
                    'end_time_formatted' => $value->endTimeFormatted,
                    'start_time_formatted' => $value->startTimeFormatted,
                    'holiday_applicability_type' => $value->holidayApplicabilityType,
                    'status' => $value->status,
                    'tenancy_price' => $value->tenancyPrice,
                    'tenancy_price_with_fraction' => $value->tenancyPriceWithFraction,
                    'per_person_price' => $value->perPersonPrice,
                    'per_person_price_with_fraction' => $value->perPersonPriceWithFraction,
                    'max_simultaneous_reservations' => $value->maxSimultaneousReservations,
                    'max_simultaneous_people' => $value->maxSimultaneousPeople
                ];
            }
            $response[] = [
                'rental_plan_id' => $interval->rentalPlanId,
                'rental_plan_name' => $interval->rentalPlanName,
                'rental_plan_group' => $interval->planGroup,
                'rental_intervals' => $rentalIntervalInformation
            ];
        }

        $response = $rentalSpaceRentalIntervalRepository->getStatusPlan($response);
        return response()->json($response, 200);
    }

    /**
     * Admin - GET detail interval of plan (use planId)
     */
    public function detailRentalIntervalByPlanId($rentalSpaceId, $rentalPlanId): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalIntervalDetailByPlanIdGetApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceRentalPlanRepository
        );
        $command = new RentalSpaceRentalIntervalDetailByPlanIdGetCommand(
            $rentalSpaceId,
            $rentalPlanId
        );

        $intervalResult = $applicationService->handle($command);
        $response = [];
        foreach ($intervalResult->intervals as $value) {
            $response[] = [
                'id' => $value->id,
                'applicability_periods' => $value->applicabilityPeriods,
                'end_time_formatted' => $value->endTimeFormatted,
                'start_time_formatted' => $value->startTimeFormatted,
                'holiday_applicability_type' => $value->holidayApplicabilityType,
                'status' => $value->status,
                'tenancy_price' => $value->tenancyPrice,
                'tenancy_price_with_fraction' => $value->tenancyPriceWithFraction,
                'per_person_price' => $value->perPersonPrice,
                'per_person_price_with_fraction' => $value->perPersonPriceWithFraction,
                'max_simultaneous_reservations' => $value->maxSimultaneousReservations,
                'max_simultaneous_people' => $value->maxSimultaneousPeople
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Admin - GET detail interval of plan (by a day)
     * @throws InvalidArgumentException
     */
    public function detailRentalIntervalInThisDay($rentalSpaceId, $rentalPlanId, RentalIntervalInThisDayRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalIntervalOfPlanInThisDayGetApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceRentalPlanRepository
        );
        $command = new RentalIntervalOfPlanInThisDayGetCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $request->month,
            $request->year
        );
        $intervalApplications = $applicationService->handle($command);
        $response = [];
        foreach ($intervalApplications->intervals as $interval) {
            $intervalOfDay = [];
            foreach ($interval->intervals as $item) {
                $intervalOfDay[] = [
                    'id' => $item->id,
                    'applicability_periods' => $item->applicabilityPeriods,
                    'end_time_formatted' => $item->endTimeFormatted,
                    'start_time_formatted' => $item->startTimeFormatted,
                    'holiday_applicability_type' => $item->holidayApplicabilityType,
                    'status' => $item->status,
                    'tenancy_price' => $item->tenancyPrice,
                    'tenancy_price_with_fraction' => $item->tenancyPriceWithFraction,
                    'per_person_price' => $item->perPersonPrice,
                    'per_person_price_with_fraction' => $item->perPersonPriceWithFraction,
                    'max_simultaneous_reservations' => $item->maxSimultaneousReservations,
                    'max_simultaneous_people' => $item->maxSimultaneousPeople
                ];
            }
            $response[] = [
                'date' => $interval->date,
                'interval' => $intervalOfDay
            ];
        }
        $response = $this->checkDateBooking($rentalSpaceId, $response);

        return response()->json(['status' => 200, 'data' => $response]);
    }

    public function checkDateBooking($spaceId, $data)
    {
        $response = [];

        $rentalPlanRepository = new RentalSpaceRentalPlanRepository();
        foreach ($data as $item) {


            $convertDate = implode('', explode('-', strtolower($item['date'])));
            $dataResult = $rentalPlanRepository->getListIntervalOfPlan($spaceId, $convertDate);

            if (!empty($dataResult['item'])) {

                $allTime = count($dataResult['item']);

                $timeLost = [];

                foreach ($dataResult['item'] as $time) {
                    if (!empty($time['booked'])) {
                        $timeLost[] = $time;
                    }
                }

                $timeLost = count($timeLost);

                if ($timeLost == 0) {
                    $timeCurrent  = "◎";
                } elseif ($allTime == $timeLost) {
                    $timeCurrent  = "✕";
                } elseif ($allTime / 2 < $timeLost) {
                    $timeCurrent  = "△";
                } elseif ($allTime / 2 > $timeLost) {
                    $timeCurrent  = "◯";
                }

                $item['timeCurrent'] = $timeCurrent;
            } else {
                $item['timeCurrent'] = "✕";
            }

            $timeNow = Carbon::now()->format('Y-m-d');
            if ($timeNow > $item['date']) {
                $item['checkDateBooking'] = true;
            }

            $response[] = $item;
        }

        return $response;
    }
    /**
     * GET - detail one interval by Id
     */
    public function detailRentalIntervalById($rentalIntervalId): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalIntervalDetailByIdGetApplicationService(
            $rentalSpaceRentalIntervalRepository
        );
        $command = new RentalIntervalDetailByIdGetCommand(
            $rentalIntervalId
        );

        $intervalResult = $applicationService->handle($command);
        $response = [];
        if (!empty($intervalResult->intervals)) {
            $response = [
                'rental_interval_id' => $intervalResult->intervals->id,
                'applicability_periods' => $intervalResult->intervals->applicabilityPeriods,
                'end_time_formatted' => $intervalResult->intervals->endTimeFormatted,
                'start_time_formatted' => $intervalResult->intervals->startTimeFormatted,
                'holiday_applicability_type' => $intervalResult->intervals->holidayApplicabilityType,
                'status' => $intervalResult->intervals->status,
                'tenancy_price' => $intervalResult->intervals->tenancyPrice,
                'tenancy_price_with_fraction' => $intervalResult->intervals->tenancyPriceWithFraction,
                'per_person_price' => $intervalResult->intervals->perPersonPrice,
                'per_person_price_with_fraction' => $intervalResult->intervals->perPersonPriceWithFraction,
                'max_simultaneous_reservations' => $intervalResult->intervals->maxSimultaneousReservations,
                'max_simultaneous_people' => $intervalResult->intervals->maxSimultaneousPeople
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * PUT - API update interval
     */
    public function updateRentalInterval(RentalSpaceRentalIntervalUpdateRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalSpaceRentalIntervalPutApplicationService(
            $rentalSpaceRentalIntervalRepository
        );

        $command = new RentalSpaceRentalIntervalPutCommand(
            $request['ids'],
            $request['status'],
            $request['applicability_periods'],
            $request['holiday_applicability_type'],
            $request['tenancy_price'],
            $request['per_person_price'],
            $request['max_simultaneous_reservations'],
            $request['max_simultaneous_people']
        );
        $rentalIntervalIds = $applicationService->handle($command);
        return response()->json([
            'message' => 'Update successfully !',
            'rental_interval_ids' => $rentalIntervalIds->rentalIntervalIds
        ], 200);
    }

    /**
     * Update rental interval slot and override
     */
    public function updateRentalIntervalSlotOverride($rentalSpaceId, $rentalPlanId, Request $request): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalIntervalSlotOverrideUpdatePutApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceRentalPlanRepository
        );

        $rentalIntervals = [];
        foreach ($request['rental_intervals'] as $interval) {
            $rentalIntervals[] = new RentalIntervalSlotOverride(
                $interval['interval_id'],
                $interval['day_ident'],
                $interval['interval_start_time'],
                $interval['interval_end_time']
            );
        }


        $command = new RentalIntervalSlotOverrideUpdatePutCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $rentalIntervals,
            $request['note'] ?? null,
            $request['tenancy_price'],
            $request['per_person_price'] ?? 0
        );
        $responses = $applicationService->handle($command);

        return response()->json([
            'rental_plan_id' => $responses->rentalPlanId
        ], 200);
    }

    /**
     * Detail Rental Interval Override In This Day
     */
    public function detailRentalIntervalOverrideInThisDay($rentalSpaceId, $rentalPlanId, RentalIntervalInThisDayRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalIntervalOverrideOfPlanInThisDayGetApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceRentalPlanRepository
        );
        $command = new RentalIntervalOverrideOfPlanInThisDayGetCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $request->month,
            $request->year
        );
        $intervalOverrideApplications = $applicationService->handle($command);
        $response = [];

        foreach ($intervalOverrideApplications->intervals as $interval) {
            $intervalOfDay = [];
            foreach ($interval->intervals as $item) {
                $intervalOfDay[] = [
                    'rental_interval_override_id' => $item->rentalIntervalOverrideId,
                    'rental_interval_id' => $item->rentalIntervalId,
                    'dayIndent' => $item->dayIndent,
                    'start_time_formatted' => $item->intervalStartTime,
                    'end_time_formatted' => $item->intervalEndTime,
                    'tenancy_price' => $item->tenancyPrice
                ];
            }
            $response[] = [
                'date' => $interval->date,
                'interval_override' => $intervalOfDay
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * GET - Detail Rental Space Rental Slot Interval Cache Entry In This Day
     */
    public function detailRentalSpaceRentalSlotIntervalCacheEntryInThisDay($rentalSpaceId, $rentalPlanId, RentalIntervalInThisDayRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceRentalPlanRepository
        );
        $command = new RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $request->month,
            $request->year
        );
        $intervalSlotApplications = $applicationService->handle($command);
        $response = [];

        foreach ($intervalSlotApplications->slotsCacheEntry as $slot) {
            $slotOfDay = [];
            foreach ($slot->slotsCacheEntry as $item) {
                $slotOfDay[] = [
                    'rental_slot_cache_entry_id' => $item->rentalSlotCacheEntryId,
                    'rental_space_id' => $item->rentalSpaceId,
                    'rental_interval_id' => $item->rentalIntervalId,
                    'rental_plan_id' => $item->rentalPlanId,
                    'dayIndent' => $item->dayIndent,
                    'start_time_formatted' => $item->intervalStartTime,
                    'end_time_formatted' => $item->intervalEndTime,
                    'tenancy_price' => $item->tenancyPrice,
                    'per_person_price' => $item->perPersonPrice,
                    'available_seats_count' => $item->availableSeatsCount,
                    'most_generous_reservation_window_close_time' => $item->mostGenerousReservationWindowCloseTime,
                    'status' => $item->status,
                ];
            }
            $response[] = [
                'date' => $slot->date,
                'slots_cache_entry' => $slotOfDay
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * GET - Detail Rental Space Rental Slot Unavailable Cache Entry In This Day
     */
    public function detailRentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDay($rentalSpaceId, $rentalPlanId, RentalIntervalInThisDayRequest $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $applicationService = new RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceGeneralRepository
        );
        $command = new RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $request->month,
            $request->year
        );
        $intervalSlotUnavailableApplications = $applicationService->handle($command);
        $response = [];

        foreach ($intervalSlotUnavailableApplications->slotsUnavailableCacheEntry as $slotUnavailable) {
            $slotUnavailableOfDay = [];
            foreach ($slotUnavailable->slotsCacheEntry as $item) {
                $slotUnavailableOfDay[] = [
                    'rental_slot_unavailable_cache_entry_id' => $item->rentalSlotCacheEntryId,
                    'rental_space_id' => $item->rentalSpaceId,
                    'rental_interval_id' => $item->rentalIntervalId,
                    'dayIndent' => $item->dayIndent,
                    'tenancy_price' => $item->tenancyPrice,
                    'per_person_price' => $item->perPersonPrice,
                    'available_seats_count' => $item->availableSeatsCount,
                    'most_generous_reservation_window_close_time' => $item->mostGenerousReservationWindowCloseTime,
                    'status' => $item->status,
                ];
            }
            $response[] = [
                'date' => $slotUnavailable->date,
                'slots_unavailable_cache_entry' => $slotUnavailableOfDay
            ];
        }
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Delete Rental Interval Override In This Day
     */
    public function deleteRentalIntervalOverride(Request $request): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $applicationService = new RentalIntervalOverrideDeleteApplicationService(
            $rentalSpaceRentalIntervalRepository,
        );
        $rentalIntervalOverrides = [];
        if ($request->has('rental_interval_overrides')) {
            foreach ($request['rental_interval_overrides'] as $intervalOverride) {
                $rentalIntervalOverrides[] = new RentalIntervalOverrideDelete(
                    $intervalOverride['rental_interval_id'],
                    $intervalOverride['rental_interval_override_id'],
                );
            }
        }
        $command = new RentalIntervalOverrideDeleteCommand(
            $rentalIntervalOverrides
        );
        $applicationService->handle($command);
        return response()->json(['status' => 200, 'message' => 'Delete Successfully !']);
    }

    /**
     * @param $rentalSpaceId
     * @param $rentalPlanId
     * @param $rentalIntervalId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalInterval($rentalSpaceId, $rentalPlanId, $rentalIntervalId): JsonResponse
    {
        $rentalSpaceRentalIntervalRepository = new RentalSpaceRentalIntervalRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $rentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceIntervalDeleteApplicationService(
            $rentalSpaceRentalIntervalRepository,
            $rentalSpaceGeneralRepository,
            $rentalPlanRepository
        );
        $command = new RentalSpaceIntervalDeleteCommand(
            $rentalSpaceId,
            $rentalPlanId,
            $rentalIntervalId
        );
        $applicationService->handle($command);
        return response()->json(['status' => 200, 'message' => 'Delete Successfully !']);
    }
}
