<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Constants\CommonConst;
use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanGroupId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanImageInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanReservationOptionType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanStatusType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\CommonConstants;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlan;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlanGroup;
use App\Bundle\RentalSpaceBundle\Domain\Model\ReservationOptionTypeId;
use App\Models\RentalSpaceRentalPlan as ModelRentalPlan;
use App\Models\RentalSpaceRentalPlanGroup as ModelRentalPlanGroup;
use App\Models\RentalSpaceRentalPlanEav as ModelRentalPlanEav;
use App\Models\RentalSpaceRentalPlanGroupEav as ModelRentalPlanGroupEav;
use App\Models\RentalSpaceRentalPlanRentalPlanGroup as ModelRentalSpaceRentalPlanRentalPlanGroup;
use App\Models\RentalSpaceRentalPlanImage as ModelRentalPlanImage;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class RentalSpaceRentalPlanRepository implements IRentalSpaceRentalPlanRepository
{
    /**
     * Create rental space rental plan
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep, RentalPlanId}
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceRentalPlan(RentalSpace $rentalSpace): array
    {
        // TODO: Implement createRentalSpaceRentalPlan() method.
        $rentalSpaceRentalPlan = $rentalSpace->getRentalSpaceRentalPlan();
        $entity = ModelRentalPlan::create([
            'rental_space_id' => $rentalSpace->getRentalSpaceId()->getValue(),
            'status' => 'active',
            'bank_account_id' => $rentalSpaceRentalPlan->getBankAccountId(),
            'allowing_multi_booking' => $rentalSpaceRentalPlan->getReservationSettingAllowingMultiBooking() ?? 1,
            'requiring_contiguous' => $rentalSpaceRentalPlan->getReservationSettingRequiringContiguous() ?? 1,
            'min_contiguous_duration_minutes' => $rentalSpaceRentalPlan->getReservationSettingMinContiguousDurationMinutes(),
            'type' => $rentalSpaceRentalPlan->getReservationType()->getValue()
        ]);

        $discountRules = [];
        if (!empty($rentalSpaceRentalPlan->getRentalPlanContiguousUseDiscountRule())) {
            foreach ($rentalSpaceRentalPlan->getRentalPlanContiguousUseDiscountRule() as $discountRule) {
                $discountRules[] = [
                    'total_minute_time_of_the_frame' => $discountRule->getTotalMinuteTimeOfTheFrame(),
                    'total_minute_time_of_the_frame_type' => $discountRule->getTotalMinuteTimeOfTheFrameType(),
                    'discount_from_total_amount' => $discountRule->getDiscountFromTotalAmount(),
                    'discount_from_total_amount_type' => $discountRule->getDiscountFromTotalAmountType(),
                ];
            }
        }
        $rentalSpaceRentalPlanEav = [
            "plan_name" => $rentalSpaceRentalPlan->getPlanName(),
            "day_when_not_deny_request" => json_encode($rentalSpaceRentalPlan->getDayWhenNotDenyRequest()),
            "payment_method_creditCard" => $rentalSpaceRentalPlan->getPaymentMethodCreditCard() ?? "credit_card",
            "payment_method_bankTransfer" => $rentalSpaceRentalPlan->getPaymentMethodBankTransfer() ?? null,
            "payment_method_cashOnSite" => $rentalSpaceRentalPlan->getPaymentMethodCashOnSite() ?? null,
            "payment_method_paid" => $rentalSpaceRentalPlan->getPaymentMethodPaid() ?? null,
            "payment_method_chooseLaterByCustomer" => $rentalSpaceRentalPlan->getPaymentMethodChooseLaterByCustomer() ?? null,
            "cleaning_duration_minutes" => $rentalSpaceRentalPlan->getCleaningDurationMinutes() ?? 0,
            "reservation_early_notice_minutes_creditCard" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCreditCard() ?? 5,
            "reservation_early_notice_minutes_creditCard_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCreditCardType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_bankTransfer" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesBankTransfer() ?? null,
            "reservation_early_notice_minutes_bankTransfer_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesBankTransferType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_cashOnSite" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCashOnSite() ?? null,
            "reservation_early_notice_minutes_cashOnSite_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCashOnSiteType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_paid" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesPaid() ?? null,
            "reservation_early_notice_minutes_paid_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesPaidType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_chooseLaterByCustomer" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomer() ?? null,
            "reservation_early_notice_minutes_chooseLaterByCustomer_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomerType() ?? "分前まで受け付け",
            "rental_plan_contiguous_use_discount_rules" => json_encode($discountRules),
            "commission_rate" => $rentalSpaceRentalPlan->getCommissionRate()
        ];
        if (!empty($rentalSpaceRentalPlan->getReservationOptions())) {
            foreach ($rentalSpaceRentalPlan->getReservationOptions() as $reservationOption) {
                $rentalSpaceRentalPlanEav["reservation_option_" . $reservationOption->getOrderNumber()] = $reservationOption->getReservationOptionId()->getValue();
            }
        }
        foreach ($rentalSpaceRentalPlanEav as $key => $value) {
            if ($value === null) {
                unset($rentalSpaceRentalPlanEav[$key]);
            } else {
                ModelRentalPlanEav::create([
                    'namespace' => $entity->id,
                    'attribute' => $key,
                    'value' => $value
                ]);
            }
        }

        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();

        return [
            new RentalSpaceId($rentalSpaceModel->id),
            new RentalSpaceDraftStep($rentalSpaceModel->draft_step),
            new RentalPlanId($entity->id)
        ];
    }

    /**
     * @param RentalPlanId $rentalPlanId
     * @param RentalPlanImageInformation $imageUploadInformation
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function uploadImageRentalPlan(RentalPlanId $rentalPlanId, RentalPlanImageInformation $imageUploadInformation): bool
    {
        // TODO: Implement uploadImageRentalPlan() method.
        $entity = ModelRentalPlanImage::create([
            'id' => $imageUploadInformation->getImageId(),
            'parent_id' => $rentalPlanId->getValue(),
            's3key' => $imageUploadInformation->getS3key(),
            'width' => $imageUploadInformation->getWidth(),
            'height' => $imageUploadInformation->getHeight(),
            'length' => $imageUploadInformation->getLength(),
            'extension' => $imageUploadInformation->getExtension(),
            'creation_time' => time(),
            'order_number' => 0
        ]);
        return true;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array
    {
        // TODO: Implement findById() method.
        $entities = ModelRentalPlan::where('rental_space_id', $rentalSpaceId->getValue())
            ->with(['rentalSpaceRentalInterval', 'rentalSpaceRentalPlanEav'])->get()->toArray();
        if (!$entities) {
            return null;
        }
        $intervals = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_rental_interval'])) {
                $intervalGroupByQuery = DB::table('rental_space_rental_interval')->where('rental_plan_id', $entity['id'])
                    ->select(['applicability_periods'])
                    ->groupBy('applicability_periods')
                    ->get()->toArray();

                $intervalGroupByData = [];
                foreach ($intervalGroupByQuery as $value) {
                    $intervalQueries = [];
                    foreach ($entity['rental_space_rental_interval'] as $interval) {
                        if ($interval['applicability_periods'] === $value->applicability_periods) {
                            $intervalQueries[] = $interval;
                        }
                    }

                    $intervalGroupByData[] = [
                        "applicability_periods" => json_decode($intervalQueries[0]['applicability_periods']),
                        "end_time_formatted" => $intervalQueries[count($intervalQueries) - 1]['end_time_formatted'],
                        "start_time_formatted" => $intervalQueries[0]['start_time_formatted'],
                        "per_person_price" => $intervalQueries[0]['per_person_price'],
                        "tenancy_price" => $intervalQueries[0]['tenancy_price']
                    ];
                }
                $entity['rental_space_rental_interval'] = $intervalGroupByData;
            }
            $planName = null;
            if (!empty($entity['rental_space_rental_plan_eav'])) {
                foreach ($entity['rental_space_rental_plan_eav'] as $planEav) {
                    if ($planEav['attribute'] === 'plan_name') {
                        $planName = $planEav['value'];
                    }
                }
            }
            $entity['plan_name'] = $planName;
            unset($entity['rental_space_rental_plan_eav']);
            $intervals[] = $entity;
        }
        return $intervals;
    }

    /**
     * GET - Detail Rental Plan
     *
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalPlanId $rentalPlanId
     *
     * @return array{RentalSpaceRentalPlan, RentalPlanImageInformation}|null
     * @throws InvalidArgumentException
     */
    public function findById(RentalSpaceId $rentalSpaceId, RentalPlanId $rentalPlanId): ?array
    {
        $entities = ModelRentalPlan::where('id', $rentalPlanId->getValue())
            ->where('rental_space_id', $rentalSpaceId->getValue())
            ->with(['rentalSpaceRentalPlanImage', 'rentalSpaceRentalPlanEav'])->get()->toArray();
        if (!$entities) {
            return null;
        }

        $rentalPlans = [];
        $rentalPlanImage = [];
        $reservationOptions = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_rental_plan_eav'])) {
                foreach ($entity['rental_space_rental_plan_eav'] as $planEav) {
                    if (stristr($planEav['attribute'], 'reservation_option_')) {
                        $reservationOptions[] = new RentalPlanReservationOptionType(
                            new ReservationOptionTypeId($planEav['value']),
                            intval(explode('_', $planEav['attribute'])[2])
                        );
                    }
                    $entity[$planEav['attribute']] =  $planEav['value'];
                }
            }
            $entity['reservation_options'] = $reservationOptions;
            unset($entity['rental_space_rental_plan_eav']);
            $rentalPlans = $entity;

            if (!empty($entity['rental_space_rental_plan_image'])) {
                foreach ($entity['rental_space_rental_plan_image'] as $planImage) {
                    $rentalPlanImage = new RentalPlanImageInformation(
                        $planImage['id'],
                        $planImage['s3key'],
                        $planImage['height'],
                        $planImage['width'],
                        $planImage['length'],
                        $planImage['extension']
                    );
                }
            }
        }

        $rentalPlanResult = new RentalSpaceRentalPlan(
            $rentalSpaceId,
            $rentalPlanId,
            $rentalPlans['status'],
            $rentalPlans['plan_name'] ?? '',
            RentalPlanType::fromValue($rentalPlans['type']),
            json_decode($rentalPlans['day_when_not_deny_request'] ?? []),
            $rentalPlans['payment_method_creditCard'] ?? null,
            $rentalPlans['payment_method_bankTransfer'] ?? null,
            $rentalPlans['payment_method_cashOnSite'] ?? null,
            $rentalPlans['payment_method_paid'] ?? null,
            $rentalPlans['payment_method_chooseLaterByCustomer'] ?? null,
            $rentalPlans['bank_account_id'] ?? null,
            $rentalPlans['cleaning_duration_minutes'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_creditCard'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_creditCard_type'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_bankTransfer'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_bankTransfer_type'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_cashOnSite'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_cashOnSite_type'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_paid'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_paid_type'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_chooseLaterByCustomer'] ?? null,
            $rentalPlans['reservation_early_notice_minutes_chooseLaterByCustomer_type'] ?? null,
            $rentalPlans['allowing_multi_booking'] ?? null,
            $rentalPlans['requiring_contiguous'] ?? null,
            $rentalPlans['min_contiguous_duration_minutes'] ?? null,
            json_decode($rentalPlans['rental_plan_contiguous_use_discount_rules'] ?? ''),
            $rentalPlans['commission_rate'] ?? null,
            $rentalPlans['reservation_options']
        );

        [$rentalPlan, $rentalPlanImage] = [$rentalPlanResult, $rentalPlanImage];
        return [$rentalPlan, $rentalPlanImage];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalPlanId|null
     * @throws InvalidArgumentException
     */
    public function firstPlanBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalPlanId
    {
        // TODO: Implement firstPlanBySpaceId() method.
        $entities = ModelRentalPlan::where('rental_space_id', $rentalSpaceId->getValue())
            ->with(['rentalSpaceRentalInterval', 'rentalSpaceRentalPlanEav'])->get()->first();
        if (!$entities) {
            return null;
        }
        return new RentalPlanId($entities->id);
    }

    /**
     * Create Plan Group
     *
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalPlanGroupId}
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceRentalPlanGroup(RentalSpace $rentalSpace): array
    {
        // TODO: Implement createRentalSpaceRentalPlanGroup() method.
        $entity = ModelRentalPlanGroup::create([
            'rental_space_id' => $rentalSpace->getRentalSpaceId()->getValue(),
            'status' => RentalPlanStatusType::fromType(RentalPlanStatusType::ACTIVE)->getValue()
        ]);
        ModelRentalPlanGroupEav::create([
            'attribute' => 'title__ja',
            'namespace' => $entity->id,
            'value' => $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupName(),
            'type' => 's'
        ]);
        foreach ($rentalSpace->getRentalSpaceRentalPlanGroup()->getRentalPlans() as $rentalPlanId) {
            ModelRentalSpaceRentalPlanRentalPlanGroup::create([
                'rental_plan_group_id' => $entity->id,
                'rental_plan_id' => $rentalPlanId->getValue()
            ]);
        }
        [$rentalSpaceId, $rentalPlanGroupId] = [
            $rentalSpace->getRentalSpaceId(),
            new RentalPlanGroupId($entity->id)
        ];
        return [$rentalSpaceId, $rentalPlanGroupId];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceRentalPlanGroup[]|null
     * @throws InvalidArgumentException
     */
    public function findAllPlanGroup(RentalSpaceId $rentalSpaceId): ?array
    {
        $entities = ModelRentalPlanGroup::with(['rentalSpaceRentalPlanGroupEav', 'rentalSpaceRentalPlanRentalPlanGroup'])->where('rental_space_id', $rentalSpaceId->getValue())->get()->toArray();
        $rentalPlanGroups = [];

        foreach ($entities as $entity) {
            $planGroupName = null;
            $rentalPlanIds = [];

            foreach ($entity['rental_space_rental_plan_group_eav'] as $planGroupEav) {
                $planGroupName = $planGroupEav['value'];
            }
            foreach ($entity['rental_space_rental_plan_rental_plan_group'] as $rentalPlanRentalPlanGroup) {
                $rentalPlanIds[] = new RentalPlanId($rentalPlanRentalPlanGroup['rental_plan_id']);
            }
            $rentalPlanGroups[] = new RentalSpaceRentalPlanGroup(
                $rentalSpaceId,
                new RentalPlanGroupId($entity['id']),
                $planGroupName,
                $rentalPlanIds,
                RentalPlanStatusType::fromValue($entity['status'])
            );
        }

        return $rentalPlanGroups;
    }

    /**
     * Detail Plan Group
     * @param RentalPlanGroupId $rentalPlanGroupId
     * @return RentalSpaceRentalPlanGroup|null
     * @throws InvalidArgumentException
     */
    public function findPlanGroupById(RentalPlanGroupId $rentalPlanGroupId): ?RentalSpaceRentalPlanGroup
    {
        $entities = ModelRentalPlanGroup::with(['rentalSpaceRentalPlanGroupEav', 'rentalSpaceRentalPlanRentalPlanGroup'])->find($rentalPlanGroupId->getValue())->toArray();
        if (!$entities) {
            return null;
        }
        $planGroupName = null;
        foreach ($entities['rental_space_rental_plan_group_eav'] as $planGroupEav) {
            $planGroupName = $planGroupEav['value'];
        }

        $rentalPlanIds = [];
        foreach ($entities['rental_space_rental_plan_rental_plan_group'] as $rentalPlanRentalPlanGroup) {
            $rentalPlanIds[] = new RentalPlanId($rentalPlanRentalPlanGroup['rental_plan_id']);
        }

        return new RentalSpaceRentalPlanGroup(
            new RentalSpaceId($entities['rental_space_id']),
            $rentalPlanGroupId,
            $planGroupName,
            $rentalPlanIds,
            RentalPlanStatusType::fromValue($entities['status'])
        );
    }

    /**
     * Update Rental Plan
     *
     * @param RentalSpace $rentalSpace
     * @return RentalPlanId
     * @throws InvalidArgumentException
     */
    public function updateRentalPlan(RentalSpace $rentalSpace): RentalPlanId
    {
        $rentalSpaceRentalPlan = $rentalSpace->getRentalSpaceRentalPlan();
        $entity = ModelRentalPlan::findOrFail($rentalSpaceRentalPlan->getRentalPlanId()->getValue());
        $entity->update([
            'status' => $rentalSpaceRentalPlan->getStatus() ?? RentalPlanStatusType::fromType(RentalPlanStatusType::ACTIVE)->getValue(),
            'bank_account_id' => $rentalSpaceRentalPlan->getBankAccountId(),
            'allowing_multi_booking' => $rentalSpaceRentalPlan->getReservationSettingAllowingMultiBooking() ?? 1,
            'requiring_contiguous' => $rentalSpaceRentalPlan->getReservationSettingRequiringContiguous() ?? 1,
            'min_contiguous_duration_minutes' => $rentalSpaceRentalPlan->getReservationSettingMinContiguousDurationMinutes(),
            'type' => $rentalSpaceRentalPlan->getReservationType()->getValue()
        ]);

        ModelRentalPlanEav::where('namespace', $rentalSpaceRentalPlan->getRentalPlanId()->getValue())->delete();

        $discountRules = [];
        if (!empty($rentalSpaceRentalPlan->getRentalPlanContiguousUseDiscountRule())) {
            foreach ($rentalSpaceRentalPlan->getRentalPlanContiguousUseDiscountRule() as $discountRule) {
                $discountRules[] = [
                    'total_minute_time_of_the_frame' => $discountRule->getTotalMinuteTimeOfTheFrame(),
                    'total_minute_time_of_the_frame_type' => $discountRule->getTotalMinuteTimeOfTheFrameType(),
                    'discount_from_total_amount' => $discountRule->getDiscountFromTotalAmount(),
                    'discount_from_total_amount_type' => $discountRule->getDiscountFromTotalAmountType(),
                ];
            }
        }
        $rentalSpaceRentalPlanEav = [
            "plan_name" => $rentalSpaceRentalPlan->getPlanName(),
            "day_when_not_deny_request" => json_encode($rentalSpaceRentalPlan->getDayWhenNotDenyRequest()),
            "payment_method_creditCard" => $rentalSpaceRentalPlan->getPaymentMethodCreditCard() ?? "credit_card",
            "payment_method_bankTransfer" => $rentalSpaceRentalPlan->getPaymentMethodBankTransfer() ?? null,
            "payment_method_cashOnSite" => $rentalSpaceRentalPlan->getPaymentMethodCashOnSite() ?? null,
            "payment_method_paid" => $rentalSpaceRentalPlan->getPaymentMethodPaid() ?? null,
            "payment_method_chooseLaterByCustomer" => $rentalSpaceRentalPlan->getPaymentMethodChooseLaterByCustomer() ?? null,
            "cleaning_duration_minutes" => $rentalSpaceRentalPlan->getCleaningDurationMinutes() ?? 0,
            "reservation_early_notice_minutes_creditCard" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCreditCard() ?? 5,
            "reservation_early_notice_minutes_creditCard_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCreditCardType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_bankTransfer" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesBankTransfer() ?? null,
            "reservation_early_notice_minutes_bankTransfer_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesBankTransferType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_cashOnSite" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCashOnSite() ?? null,
            "reservation_early_notice_minutes_cashOnSite_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesCashOnSiteType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_paid" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesPaid() ?? null,
            "reservation_early_notice_minutes_paid_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesPaidType() ?? "分前まで受け付け",
            "reservation_early_notice_minutes_chooseLaterByCustomer" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomer() ?? null,
            "reservation_early_notice_minutes_chooseLaterByCustomer_type" => $rentalSpaceRentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomerType() ?? "分前まで受け付け",
            "rental_plan_contiguous_use_discount_rules" => json_encode($discountRules),
            "commission_rate" => $rentalSpaceRentalPlan->getCommissionRate()
        ];
        if (!empty($rentalSpaceRentalPlan->getReservationOptions())) {
            foreach ($rentalSpaceRentalPlan->getReservationOptions() as $reservationOption) {
                $rentalSpaceRentalPlanEav["reservation_option_" . $reservationOption->getOrderNumber()] = $reservationOption->getReservationOptionId()->getValue();
            }
        }
        foreach ($rentalSpaceRentalPlanEav as $key => $value) {
            if ($value === null) {
                unset($rentalSpaceRentalPlanEav[$key]);
            } else {
                ModelRentalPlanEav::create([
                    'namespace' => $rentalSpaceRentalPlan->getRentalPlanId()->getValue(),
                    'attribute' => $key,
                    'value' => $value
                ]);
            }
        }

        return $rentalSpaceRentalPlan->getRentalPlanId();
    }

    public function getListIntervalOfPlan($spaceId, $dayIdent)
    {
        $dataResult = null;
        $day = new \DateTime($dayIdent);
        $weekDay = CommonConstants::WEEKDAY_MAP[$day->format(DateTimeConst::FORMAT_DAY)];
        $listPlan = ModelRentalPlan::select('id')->where('rental_space_id', $spaceId)->get()->toArray();
        if (!empty($listPlan)) {
            foreach ($listPlan as $planId) {
                $interval = null;
                $interval = ModelRentalPlan::join('rental_space_rental_interval', 'rental_space_rental_interval.rental_plan_id', 'rental_space_rental_plan.id')
                    ->join('rental_space_rental_plan_eav', 'rental_space_rental_plan_eav.namespace', 'rental_space_rental_plan.id')
                    ->select(
                        'rental_space_rental_plan.id as plan_id',
                        'rental_space_rental_interval.start_time_formatted',
                        'rental_space_rental_interval.end_time_formatted',
                        'rental_space_rental_interval.tenancy_price',
                        'rental_space_rental_plan_eav.attribute as plan_name',
                        'rental_space_rental_plan_eav.value as plan_name_value'
                    )
                    ->where('rental_space_rental_plan.id', $planId)
                    //->where('rental_space_rental_interval.applicability_periods', 'LIKE', '%' . $weekDay . '%')
                    ->where('rental_space_rental_plan_eav.attribute', 'plan_name')
                    ->where('rental_space_rental_plan.status', ModelRentalPlan::ACTIVE)
                    ->get()->toArray();
                if (!empty($interval)) {
                    $dataResult = self::convertDataResultIntervalInDay($interval);
                }
            }
        }

        if (!empty($dataResult['item'])) {
            $covertDataBooking =  $this->handelCheckTimeBooking($spaceId, $dataResult['item'], $dayIdent);
            $dataResult['item'] = $covertDataBooking;
        }

        return $dataResult;
    }

    public function handelCheckTimeBooking($spaceId, $data, $dayIdent)
    {
        $dataConvert = [];
        foreach ($data as $item) {

            $reservation = Reservation::where(function ($query) use ($spaceId, $item, $dayIdent) {

                $query->where('rental_space_id', $spaceId);
                $query->where('creation_time', $dayIdent);

                $query->where(function ($q) use ($item) {
                    $q->where('planless_start_time', '<=', $item['start_time_formatted']);
                    $q->Where('planless_end_time', '>=', $item['end_time_formatted']);
                });
            })->get()->toArray();

            if (!empty($reservation)) {
                $item['booked'] = true;
            }

            $dataConvert[] = $item;
        }

        return $dataConvert;
    }

    /**
     * @return array
     */
    private function convertDataResultIntervalInDay($data): array
    {
        $result = [];
        foreach ($data as $key => $item) {
            if ($key == 0) {
                $result['plan_name'] = $item['plan_name'];
                $result['plan_name_value'] = $item['plan_name_value'];
            }
            unset($item['plan_name']);
            unset($item['plan_name_value']);
            $result['item'][] = $item;
        }
        return $result;
    }


    /**
     * @param RentalSpace $rentalSpace
     * @return RentalPlanGroupId
     * @throws InvalidArgumentException
     */
    public function updateRentalPlanGroup(RentalSpace $rentalSpace): RentalPlanGroupId
    {
        // TODO: Implement updateRentalPlanGroup() method.
        $entity = ModelRentalPlanGroup::findOrFail($rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId()->getValue());
        $entity->update([
            'status' => $rentalSpace->getRentalSpaceRentalPlanGroup()->getStatus()->getValue(),
        ]);

        ModelRentalPlanGroupEav::where('namespace', $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId()->getValue())->delete();
        ModelRentalPlanGroupEav::create([
            'attribute' => 'title__ja',
            'namespace' => $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId()->getValue(),
            'value' => $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupName(),
            'type' => 's'
        ]);

        ModelRentalSpaceRentalPlanRentalPlanGroup::where('rental_plan_group_id', $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId()->getValue())->delete();
        foreach ($rentalSpace->getRentalSpaceRentalPlanGroup()->getRentalPlans() as $plan) {
            if ($plan->getStatus()->getValue() == RentalPlanStatusType::fromType(RentalPlanStatusType::ACTIVE)->getValue()) {
                ModelRentalSpaceRentalPlanRentalPlanGroup::create([
                    'rental_plan_group_id' => $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId()->getValue(),
                    'rental_plan_id' => $plan->getPlanId()->getValue()
                ]);
            }
        }

        return $rentalSpace->getRentalSpaceRentalPlanGroup()->getPlanGroupId();
    }
}
