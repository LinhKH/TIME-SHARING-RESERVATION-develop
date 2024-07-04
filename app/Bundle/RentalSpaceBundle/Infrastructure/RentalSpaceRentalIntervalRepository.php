<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\CalendarIntervalsInWeek;
use App\Bundle\RentalSpaceBundle\Domain\Model\CalendarMatchDayAndIntervalInMonthly;
use App\Bundle\RentalSpaceBundle\Domain\Model\CalendarMonth;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalDateAndTime;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalOverrideId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalOverrideInThisDay;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalSlotCacheEntry;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalSlotCacheEntryInThisDay;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalSlotOverride;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanRentalSlotsIntervalOverride;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSlotCacheEntryId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSlotCacheEntryStatusType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalCollection;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalGroupThisDay;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalInThisDay;
use App\Models\RentalSlotProhibitionRule as ModelRentalSlotProhibitionRule;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalIntervalOverrideConfig as ModelRentalIntervalOverrideConfig;
use App\Models\RentalSpaceRentalInterval as ModelRentalInterval;
use App\Models\RentalSlotCacheEntry as ModelRentalSlotCacheEntry;
use App\Models\RentalSlotUnavailableCacheEntry as ModelRentalSlotUnavailableCacheEntry;
use App\Models\RentalSpaceRentalPlan;
use App\Models\RentalSpaceRentalPlanGroupEav as RentalSpaceRentalPlanGroupEavModel;
use App\Models\ReservationOrderItem as ModelReservationOrderItem;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;

class RentalSpaceRentalIntervalRepository implements IRentalSpaceRentalIntervalRepository
{
    /**
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep, RentalPlanId}
     * @throws InvalidArgumentException
     * @throws TransactionException
     */

    public function createRentalSpaceRentalInterval(RentalSpace $rentalSpace): ?array
    {
        // TODO: Implement postRentalSpaceRentalInterval() method.
        $rentalSpaceRentalInterval = $rentalSpace->getRentalSpaceRentalInterval();
        $holidayApplicabilityType = $rentalSpaceRentalInterval->getHolidayApplicabilityType()->getValue();

        foreach ($rentalSpaceRentalInterval->getTimeFormatted() as $formatted) {
            ModelRentalInterval::create([
                'rental_plan_id' => $rentalSpaceRentalInterval->getRentalPlanId()->getValue(),
                'start_time_formatted' => $formatted->getStartTimeFormatted(),
                'end_time_formatted' => $formatted->getEndTimeFormatted(),
                'status' => 'active',
                'tenancy_price' => $rentalSpaceRentalInterval->setTenancyPrice($rentalSpaceRentalInterval->getTenancyPrice()),
                'per_person_price' => $rentalSpaceRentalInterval->setPerPersonPrice($rentalSpaceRentalInterval->getPerPersonPrice()),
                'maximum_simultaneous_reservations' => $rentalSpaceRentalInterval->getMaxSimultaneousReservations(),
                'maximum_simultaneous_people' => $rentalSpaceRentalInterval->getMaxSimultaneousPeople(),
                'applicability_periods' => json_encode($rentalSpaceRentalInterval->getApplicabilityPeriods()),
                'holiday_applicability_type' => $holidayApplicabilityType,
                'next_cache_build_day_ident' => null,
                'next_cache_build_lock_ident' => null,
                'tenancy_price_with_fraction' => $rentalSpaceRentalInterval->setTenancyPriceWithFraction($rentalSpaceRentalInterval->getTenancyPrice()),
                'per_person_price_with_fraction' => $rentalSpaceRentalInterval->setPerPersonPriceWithFraction($rentalSpaceRentalInterval->getPerPersonPrice()),
            ]);
        }

        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();

        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * Invalid Interval
     *
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceRentalIntervalCollection
     * @throws InvalidArgumentException
     */
    public function findCollectionRentalInterval(RentalSpace $rentalSpace): RentalSpaceRentalIntervalCollection
    {
        $rentalSpaceRentalInterval = $rentalSpace->getRentalSpaceRentalInterval();

        $entities = RentalSpaceRentalPlan::where('id', $rentalSpaceRentalInterval->getRentalPlanId()->getValue())
            ->where('rental_space_id', $rentalSpace->getRentalSpaceId()->getValue())
            ->with(['rentalSpaceRentalInterval'])->get()->toArray();

        $rentalSpaceIntervalEntities = $entities[0]['rental_space_rental_interval'];

        $rentalIntervalDateAndTimes = [];
        if (!empty($rentalSpaceIntervalEntities)) {
            $intervalGroupByQuery = DB::table('rental_space_rental_interval')->where('rental_plan_id', $rentalSpaceRentalInterval->getRentalPlanId()->getValue())
                ->select(['applicability_periods'])
                ->groupBy('applicability_periods')
                ->get()->toArray();

            foreach ($intervalGroupByQuery as $value) {
                $intervalGroupByArray = [];
                foreach ($rentalSpaceIntervalEntities as $intervalEntity) {
                    if ($intervalEntity['applicability_periods'] != $value->applicability_periods) {
                        continue;
                    }
                    $intervalGroupByArray[] = $intervalEntity;
                }
                if (empty($intervalGroupByArray)) {
                    continue;
                }
                $rentalIntervalDateAndTimes[] = new RentalIntervalDateAndTime(
                    json_decode($value->applicability_periods),
                    $intervalGroupByArray[0]['start_time_formatted'],
                    $intervalGroupByArray[count($intervalGroupByArray) - 1]['end_time_formatted'],
                );
            }
        }
        return new RentalSpaceRentalIntervalCollection($rentalIntervalDateAndTimes);
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array
    {
        $entities = RentalSpaceRentalPlan::with(['rentalSpaceRentalPlanRentalPlanGroup', 'rentalSpaceRentalInterval', 'rentalSpaceRentalPlanEav'])
            ->where('rental_space_id', $rentalSpaceId->getValue())->get()->toArray();
        if (empty($entities)) {
            return null;
        }

        $result = [];
        foreach ($entities as $entity) {

            $rentalInterval = [];
            $planName = null;
            $planGroups = [];
            foreach ($entity['rental_space_rental_interval'] as $interval) {
                $rentalInterval[] = new RentalIntervalInformation(
                    $interval['id'],
                    json_decode($interval['applicability_periods'] ?? ''),
                    $interval['end_time_formatted'],
                    $interval['start_time_formatted'],
                    $interval['holiday_applicability_type'],
                    $interval['status'],
                    $interval['tenancy_price'] ?? null,
                    $interval['tenancy_price_with_fraction'] ?? null,
                    $interval['per_person_price'] ?? null,
                    $interval['per_person_price_with_fraction'] ?? null,
                    $interval['maximum_simultaneous_reservations'] ?? null,
                    $interval['maximum_simultaneous_people'] ?? null
                );
            }
            foreach ($entity['rental_space_rental_plan_eav'] as $planEav) {
                if ($planEav['attribute'] === 'plan_name') {
                    $planName = $planEav['value'];
                }
            }
            foreach ($entity['rental_space_rental_plan_rental_plan_group'] as $planGroup) {
                $planGroupEav = RentalSpaceRentalPlanGroupEavModel::where('namespace', $planGroup['rental_plan_group_id'])->get()->toArray();
                $planGroups[] = [
                    'plan_group_id' => $planGroup['rental_plan_group_id'],
                    'plan_group_name' => $planGroupEav[0]['value']
                ];
            }
            $result[] = [
                'rentalPlanId' => $entity['id'],
                'rentalPlanName' => $planName,
                'planGroup' => $planGroups,
                "rentalIntervals" => $rentalInterval
            ];
        }
        return $result;
    }

    /**
     * GET detail interval of plan (use planId)
     *
     * @param RentalPlanId $rentalPlanId
     * @return RentalIntervalInformation[]|null
     */
    public function findAllIntervalByPlanId(RentalPlanId $rentalPlanId): ?array
    {
        $entities = ModelRentalInterval::where('rental_plan_id', $rentalPlanId->getValue())->get()->toArray();
        if (empty($entities)) {
            return [];
        }

        $rentalInterval = [];
        foreach ($entities as $interval) {
            $rentalInterval[] = new RentalIntervalInformation(
                $interval['id'],
                json_decode($interval['applicability_periods'] ?? ''),
                $interval['end_time_formatted'],
                $interval['start_time_formatted'],
                $interval['holiday_applicability_type'],
                $interval['status'],
                $interval['tenancy_price'] ?? null,
                $interval['tenancy_price_with_fraction'] ?? null,
                $interval['per_person_price'] ?? null,
                $interval['per_person_price_with_fraction'] ?? null,
                $interval['maximum_simultaneous_reservations'] ?? null,
                $interval['maximum_simultaneous_people'] ?? null
            );
        }
        return $rentalInterval;
    }

    /**
     * find All Interval Of Plan In This Day
     *
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalSpaceRentalIntervalInThisDay[]
     * @throws Exception
     */
    public function findAllIntervalOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array
    {
        $entities = ModelRentalInterval::where('rental_plan_id', $rentalPlanId->getValue())->get()->toArray();
        if (empty($entities)) {
            return [];
        }

        $calendarMonth = new CalendarMonth($month, $year);
        $datesInMonth = $calendarMonth->getDaysInMonth();

        $rentalInterval = [];
        foreach ($entities as $interval) {
            $rentalInterval[] = new RentalIntervalInformation(
                $interval['id'],
                json_decode($interval['applicability_periods'] ?? ''),
                $interval['end_time_formatted'],
                $interval['start_time_formatted'],
                $interval['holiday_applicability_type'],
                $interval['status'],
                $interval['tenancy_price'] ?? null,
                $interval['tenancy_price_with_fraction'] ?? null,
                $interval['per_person_price'] ?? null,
                $interval['per_person_price_with_fraction'] ?? null,
                $interval['maximum_simultaneous_reservations'] ?? null,
                $interval['maximum_simultaneous_people'] ?? null
            );
        }
        $rentalIntervalGroupThisDay = new RentalSpaceRentalIntervalGroupThisDay($rentalInterval);
        $rentalIntervalGroupThisDayInWeeks = new CalendarIntervalsInWeek(
            $rentalIntervalGroupThisDay->getIntervalMonday(),
            $rentalIntervalGroupThisDay->getIntervalTuesday(),
            $rentalIntervalGroupThisDay->getIntervalWednesday(),
            $rentalIntervalGroupThisDay->getIntervalThursday(),
            $rentalIntervalGroupThisDay->getIntervalFriday(),
            $rentalIntervalGroupThisDay->getIntervalSaturday(),
            $rentalIntervalGroupThisDay->getIntervalSunday()
        );

        $intervalDaysInMonthLy = new CalendarMatchDayAndIntervalInMonthly(
            $datesInMonth,
            $rentalIntervalGroupThisDayInWeeks
        );

        $results = [];
        foreach ($intervalDaysInMonthLy->getIntervalOfDaysInMonthly() as $item) {
            $results[] = new RentalSpaceRentalIntervalInThisDay(
                new DateTime($item['date']),
                $item['interval']
            );
        }
        return $results;
    }

    /**
     * Find interval by ID
     * @param RentalIntervalId $rentalIntervalId
     * @return RentalIntervalInformation|null
     */
    public function findIntervalById(RentalIntervalId $rentalIntervalId): ?RentalIntervalInformation
    {
        $entities = ModelRentalInterval::find($rentalIntervalId->getValue());
        if (empty($entities)) {
            return null;
        }
        return new RentalIntervalInformation(
            $entities->id,
            json_decode($entities->applicability_periods ?? ''),
            $entities->end_time_formatted,
            $entities->start_time_formatted,
            $entities->holiday_applicability_type,
            $entities->status,
            $entities->tenancy_price ?? null,
            $entities->tenancy_price_with_fraction ?? null,
            $entities->per_person_price ?? null,
            $entities->per_person_price_with_fraction ?? null,
            $entities->maximum_simultaneous_reservations ?? null,
            $entities->maximum_simultaneous_people ?? null
        );
    }

    /**
     * Update interval
     *
     * @param RentalSpace $rentalSpace
     * @return RentalIntervalId[]
     */
    public function updateRentalInterval(RentalSpace $rentalSpace): array
    {
        // TODO: Implement updateRentalInterval() method.
        $rentalSpaceRentalInterval = $rentalSpace->getRentalSpaceRentalInterval();
        $holidayApplicabilityType = $rentalSpaceRentalInterval->getHolidayApplicabilityType()->getValue();
        $status = $rentalSpaceRentalInterval->getStatus();
        $tenancyPrice = $rentalSpaceRentalInterval->setTenancyPrice($rentalSpaceRentalInterval->getTenancyPrice());
        $perPersonPrice = $rentalSpaceRentalInterval->setPerPersonPrice($rentalSpaceRentalInterval->getPerPersonPrice());
        foreach ($rentalSpaceRentalInterval->getRentalIntervalIds() as $intervalId) {
            $intervalQuery = ModelRentalInterval::find($intervalId->getValue());
            $update = [
                'maximum_simultaneous_reservations' => $rentalSpaceRentalInterval->getMaxSimultaneousReservations(),
                'maximum_simultaneous_people' => $rentalSpaceRentalInterval->getMaxSimultaneousPeople(),
                'tenancy_price_with_fraction' => $rentalSpaceRentalInterval->setTenancyPriceWithFraction($rentalSpaceRentalInterval->getTenancyPrice()),
                'per_person_price_with_fraction' => $rentalSpaceRentalInterval->setPerPersonPriceWithFraction($rentalSpaceRentalInterval->getPerPersonPrice()),
            ];

            if (!empty($rentalSpaceRentalInterval->getApplicabilityPeriods())) {
                $update['applicability_periods'] = json_encode($rentalSpaceRentalInterval->getApplicabilityPeriods());
            }

            if (!empty($holidayApplicabilityType)) {
                $update['holiday_applicability_type'] = $holidayApplicabilityType;
            }

            if (!empty($status)) {
                $update['status'] = $status;
            }

            if (isset($tenancyPrice)) {
                $update['tenancy_price'] = $tenancyPrice;
            }

            if (isset($perPersonPrice)) {
                $update['per_person_price'] = $perPersonPrice;
            }

            $intervalQuery->update($update);
        }

        return $rentalSpaceRentalInterval->getRentalIntervalIds();
    }

    /**
     * @param RentalPlanRentalSlotsIntervalOverride $rentalIntervalSlotsInterval
     * @return RentalPlanId
     */
    public function createOrUpdateRentalIntervalSlotsOverride(RentalPlanRentalSlotsIntervalOverride $rentalIntervalSlotsInterval): RentalPlanId
    {
        // TODO: Implement createOrUpdateRentalIntervalSlotsOverride() method.
        foreach ($rentalIntervalSlotsInterval->getRentalIntervals() as $intervalSlotOverride) {
            $intervalOverrideId = $intervalSlotOverride->getRentalIntervalId()->getValue() . '-' . $intervalSlotOverride->getDayIndent()->format(DateTimeConst::FORMAT_Ymd);
            $entity = ModelRentalIntervalOverrideConfig::find($intervalOverrideId);
            if (empty($entity)) {
                ModelRentalIntervalOverrideConfig::create([
                    'id' => $intervalOverrideId,
                    'rental_interval_id' => $intervalSlotOverride->getRentalIntervalId()->getValue(),
                    'day_ident' => (int)$intervalSlotOverride->getDayIndent()->format(DateTimeConst::FORMAT_Ymd),
                    'note' => $rentalIntervalSlotsInterval->getNote(),
                    'per_person_price' => $rentalIntervalSlotsInterval->getPerPersonPrice(),
                    'per_person_price_with_fraction' => $rentalIntervalSlotsInterval->getPerPersonPriceWithFraction(),
                    'tenancy_price' => $rentalIntervalSlotsInterval->getTenancyPrice(),
                    'tenancy_price_with_fraction' => $rentalIntervalSlotsInterval->getTenancyPriceWithFraction()
                ]);
            } else {
                $entity->update([
                    'id' => $intervalOverrideId,
                    'rental_interval_id' => $intervalSlotOverride->getRentalIntervalId()->getValue(),
                    'day_ident' => (int)$intervalSlotOverride->getDayIndent()->format(DateTimeConst::FORMAT_Ymd),
                    'note' => $rentalIntervalSlotsInterval->getNote(),
                    'per_person_price' => $rentalIntervalSlotsInterval->getPerPersonPrice(),
                    'per_person_price_with_fraction' => $rentalIntervalSlotsInterval->getPerPersonPriceWithFraction(),
                    'tenancy_price' => $rentalIntervalSlotsInterval->getTenancyPrice(),
                    'tenancy_price_with_fraction' => $rentalIntervalSlotsInterval->getTenancyPriceWithFraction()
                ]);
            }
        }
        return $rentalIntervalSlotsInterval->getPlanId();
    }

    /**
     * Get interval override in this day
     *
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalIntervalOverrideInThisDay[]
     * @throws Exception
     */
    public function findAllOverrideIntervalOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array
    {
        // TODO: Implement findAllOverrideIntervalOfPlanInThisDay() method.
        $entities = ModelRentalInterval::with(['rentalIntervalOverrideConfig'])->where('rental_plan_id', $rentalPlanId->getValue())->get()->toArray();
        if (empty($entities)) {
            return [];
        }

        $calendarMonth = new CalendarMonth($month, $year);
        $datesInMonth = $calendarMonth->getDaysInMonth();

        $rentalInterval = [];
        foreach ($entities as $interval) {
            foreach ($interval['rental_interval_override_config'] as $overrideInterval)
                $rentalInterval[] = new RentalIntervalSlotOverride(
                    new RentalIntervalOverrideId($overrideInterval['id']),
                    new RentalIntervalId($overrideInterval['rental_interval_id']),
                    new DateTime($overrideInterval['day_ident']),
                    new DateTime($interval['end_time_formatted']),
                    new DateTime($interval['start_time_formatted']),
                    $overrideInterval['tenancy_price'] ?? null,
                );
        }

        $rentalIntervalOverrides = [];
        foreach ($datesInMonth as $date) {
            $rentalIntervalOverride = [];

            foreach ($rentalInterval as $key => $value) {
                if ($value->getDayIndent()->format(DateTimeConst::FORMAT_YMD) === $date->format(DateTimeConst::FORMAT_YMD)) {
                    $rentalIntervalOverride[] = $value;
                    unset($rentalInterval[$key]);
                }
            }
            $rentalIntervalOverrides[] = new RentalIntervalOverrideInThisDay(
                $date,
                $rentalIntervalOverride
            );
        }

        return $rentalIntervalOverrides;
    }

    /**
     * Get Slot Cache Entry Of Plan In This Day
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalIntervalSlotCacheEntryInThisDay[]
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findAllSlotCacheEntryOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array
    {
        // TODO: Implement findAllSlotCacheEntryOfPlanInThisDay() method.
        $entities = ModelRentalSlotCacheEntry::with(['rentalPlan', 'rentalSpaceRentalInterval', 'rentalSpace'])->where('rental_plan_id', $rentalPlanId->getValue())->get()->toArray();
        if (empty($entities)) {
            return [];
        }

        $calendarMonth = new CalendarMonth($month, $year);
        $datesInMonth = $calendarMonth->getDaysInMonth();

        $rentalSlotsData = [];
        foreach ($entities as $slot) {
            $rentalSlotsData[] = new RentalIntervalSlotCacheEntry(
                new RentalSlotCacheEntryId($slot['id']),
                new RentalSpaceId($slot['rental_space_id']),
                new RentalPlanId($slot['rental_plan_id']),
                new RentalIntervalId($slot['rental_interval_id']),
                new DateTime($slot['day_ident']),
                new DateTime($slot['start_time']),
                new DateTime($slot['end_time']),
                $slot['tenancy_price'],
                $slot['per_person_price'],
                $slot['available_seats_count'],
                new DateTime($slot['most_generous_reservation_window_close_time']),
                null
            );
        }

        $rentalSlotsIntervals = [];
        foreach ($datesInMonth as $date) {
            $rentalSlotInterval = [];
            foreach ($rentalSlotsData as $key => $value) {
                if ($value->getDayIndent()->format(DateTimeConst::FORMAT_YMD) === $date->format(DateTimeConst::FORMAT_YMD)) {
                    $rentalSlotInterval[] = $value;
                    unset($rentalSlotsData[$key]);
                }
            }
            $rentalSlotsIntervals[] = new RentalIntervalSlotCacheEntryInThisDay(
                $date,
                $rentalSlotInterval
            );
        }

        return $rentalSlotsIntervals;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param int $month
     * @param int $year
     * @return RentalIntervalSlotCacheEntryInThisDay[]
     * @throws Exception
     */
    public function findAllSlotUnavailableCacheEntryOfPlanInThisDay(RentalSpaceId $rentalSpaceId, int $month, int $year): array
    {
        // TODO: Implement findAllSlotUnavailableCacheEntryOfPlanInThisDay() method.
        $entities = ModelRentalSlotUnavailableCacheEntry::with(['rentalSpaceRentalInterval', 'rentalSpace'])->where('rental_space_id', $rentalSpaceId->getValue())->get()->toArray();
        if (empty($entities)) {
            return [];
        }

        $calendarMonth = new CalendarMonth($month, $year);
        $datesInMonth = $calendarMonth->getDaysInMonth();

        $rentalSlotsUnavailableData = [];
        foreach ($entities as $slotUnavailable) {
            $rentalSlotsUnavailableData[] = new RentalIntervalSlotCacheEntry(
                new RentalSlotCacheEntryId($slotUnavailable['id']),
                new RentalSpaceId($slotUnavailable['rental_space_id']),
                null,
                new RentalIntervalId($slotUnavailable['rental_interval_id']),
                new DateTime($slotUnavailable['day_ident']),
                null,
                null,
                $slotUnavailable['tenancy_price'],
                $slotUnavailable['per_person_price'],
                $slotUnavailable['available_seats_count'],
                new DateTime($slotUnavailable['most_generous_reservation_window_close_time']),
                RentalSlotCacheEntryStatusType::fromValue($slotUnavailable['status'])
            );
        }
        $rentalSlotsUnavailableIntervals = [];
        foreach ($datesInMonth as $date) {
            $rentalSlotUnavailableInterval = [];
            foreach ($rentalSlotsUnavailableData as $key => $value) {
                if ($value->getDayIndent()->format(DateTimeConst::FORMAT_YMD) === $date->format(DateTimeConst::FORMAT_YMD)) {
                    $rentalSlotUnavailableInterval[] = $value;
                    unset($rentalSlotsUnavailableData[$key]);
                }
            }
            $rentalSlotsUnavailableIntervals[] = new RentalIntervalSlotCacheEntryInThisDay(
                $date,
                $rentalSlotUnavailableInterval
            );
        }

        return $rentalSlotsUnavailableIntervals;
    }

    /**
     * @param RentalIntervalId $rentalIntervalId
     * @param RentalIntervalOverrideId $rentalIntervalOverrideId
     * @return bool
     */
    public function deleteOverrideIntervalById(RentalIntervalId $rentalIntervalId, RentalIntervalOverrideId $rentalIntervalOverrideId): bool
    {
        // TODO: Implement deleteOverrideIntervalById() method.
        ModelRentalIntervalOverrideConfig::where('rental_interval_id', $rentalIntervalId->getValue())->where('id', $rentalIntervalOverrideId->getValue())->delete();
        return true;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalPlanId $rentalPlanId
     * @param RentalIntervalId $rentalIntervalId
     * @return bool
     */
    public function deleteIntervalById(RentalSpaceId $rentalSpaceId, RentalPlanId $rentalPlanId, RentalIntervalId $rentalIntervalId): bool
    {
        ModelRentalIntervalOverrideConfig::where('rental_interval_id', $rentalIntervalId->getValue())
            ->delete();
        ModelRentalSlotCacheEntry::where('rental_interval_id', $rentalIntervalId->getValue())
            ->where('rental_plan_id', $rentalIntervalId->getValue())
            ->where('rental_space_id', $rentalSpaceId->getValue())
            ->delete();
        ModelRentalSlotProhibitionRule::where('rental_interval_id', $rentalIntervalId->getValue())
            ->delete();
        ModelRentalSlotUnavailableCacheEntry::where('rental_interval_id', $rentalIntervalId->getValue())
            ->where('rental_space_id', $rentalSpaceId->getValue())
            ->delete();
        ModelReservationOrderItem::where('rental_interval_id', $rentalIntervalId->getValue())
            ->delete();

        ModelRentalInterval::where('id', $rentalIntervalId->getValue())
            ->where('rental_plan_id', $rentalPlanId->getValue())
            ->delete();

        return true;
    }

    public function getStatusPlan($data)
    {
        $arr = [];
        foreach ($data as $item) {
            if (!empty($item['rental_plan_id'])) {
                $sql = RentalSpaceRentalPlan::where('id', $item['rental_plan_id'])->first(['id', 'status']);
                $item['rental_plan_status'] = $sql->status;
            }

            $arr[] = $item;
        }

        return $arr;
    }
}
