<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Application\RentalPlanImageInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalPlanContiguousUseDiscountRuleCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalPlanReservationOptionTypeCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailRentalPlanApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailRentalPlanCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePlanGetListByRentalSpaceIdApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePlanGetListByRentalSpaceIdCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePlanGroupListGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePlanGroupListGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostRentalPlanApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostRentalPlanCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupDetailGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupDetailGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupPostApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupPostCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupPutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanGroupPutCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanInPlanGroup;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanPutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceRentalPlanPutCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalPlanRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalPlanGroupRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalSpaceRentalPlanController extends Controller
{
    /**
     * @throws \App\Bundle\Common\Domain\Model\TransactionException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function postRentalPlan($rentalSpaceId, Request $request): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpacePostRentalPlanApplicationService(
            $rentalSpaceRentalPlanRepository
        );


        $rentalPlanContiguousUseDiscountRuleCommand = [];
        if (
            $request->has('rental_plan_contiguous_use_discount_rules') &&
            !empty($request->rental_plan_contiguous_use_discount_rules)
        ){
            foreach ($request->rental_plan_contiguous_use_discount_rules as $contiguous_use_discount_rule) {
                $rentalPlanContiguousUseDiscountRuleCommand[] = new RentalPlanContiguousUseDiscountRuleCommand (
                    $contiguous_use_discount_rule['total_minute_time_of_the_frame'],
                    $contiguous_use_discount_rule['total_minute_time_of_the_frame_type'],
                    $contiguous_use_discount_rule['discount_from_total_amount'],
                    $contiguous_use_discount_rule['discount_from_total_amount_type']
                );
            }
        }

        $rentalPlanReservationOptions = [];
        if ($request->has('reservation_options') && !empty($request->reservation_options)) {
            foreach ($request->reservation_options as $reservation_option) {
                $rentalPlanReservationOptions[] = new RentalPlanReservationOptionTypeCommand(
                    $reservation_option['reservation_option_id'],
                    $reservation_option['order_number'],
                );
            }
        }

        $command = new RentalSpacePostRentalPlanCommand(
            $rentalSpaceId,
            $request['plan_name'],
            $request['reservation_type'] ?? 'reservation-request',
            $request['day_when_not_deny_request'],
            $request['payment_method_creditCard'],
            $request['payment_method_bankTransfer'],
            $request['payment_method_cashOnSite'],
            $request['payment_method_paid'],
            $request['payment_method_chooseLaterByCustomer'],
            $request['bank_account_id'],
            $request['cleaning_duration_minutes'],
            $request['reservation_early_notice_minutes_creditCard'],
            $request['reservation_early_notice_minutes_creditCard_type'],
            $request['reservation_early_notice_minutes_bankTransfer'],
            $request['reservation_early_notice_minutes_bankTransfer_type'],
            $request['reservation_early_notice_minutes_cashOnSite'],
            $request['reservation_early_notice_minutes_cashOnSite_type'],
            $request['reservation_early_notice_minutes_paid'],
            $request['reservation_early_notice_minutes_paid_type'],
            $request['reservation_early_notice_minutes_chooseLaterByCustomer'],
            $request['reservation_early_notice_minutes_chooseLaterByCustomer_type'],
            $request['reservation_setting_allowing_multi_booking'],
            $request['reservation_setting_requiring_contiguous'],
            $request['reservation_setting_min_contiguous_duration_minutes'],
            $rentalPlanContiguousUseDiscountRuleCommand,
            $request['commission_rate'],
            $rentalPlanReservationOptions
        );
        $rentalSpace = $applicationService->handle($command);

        if ($request->has('image') && !empty($request->image)) {
            $allowedFileExtension=['jpg','jpeg','png','bmp'];
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $checkExtension = in_array($extension,$allowedFileExtension);

            if(!$checkExtension) {
                return response()->json(['invalid_file_format'], 422);
            }

            $informationImage = getimagesize($file);
            $path = $file->store('public/images');

            $rentalPlanImageInformation = new RentalPlanImageInformationCommand(
                $path,
                $informationImage[1],
                $informationImage[0],
                filesize($file),
                $extension
            );
            $applicationService->uploadImage($rentalSpace->rentalPlanId,$rentalPlanImageInformation);
        }
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'rental_plan_id' => $rentalSpace->rentalPlanId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * GET - Rental Plan by rental space id
     */
    public function getRentalPlanByRentalSpaceId($rentalSpaceId): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpacePlanGetListByRentalSpaceIdApplicationService(
            $rentalSpaceRentalPlanRepository
        );

        $command = new RentalSpacePlanGetListByRentalSpaceIdCommand($rentalSpaceId);
        $response = [];
        try {
            $response = $applicationService->handle($command);
        } catch (InvalidArgumentException|RecordNotFoundException $e) {
        }
        return response()->json($response,200);
    }

    /**
     * GET - Detail Rental Plan
     * @throws RecordNotFoundException
     */
    public function detailRentalPlan($rentalSpaceId, $rentalPlanId): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceGetDetailRentalPlanApplicationService(
            $rentalSpaceRentalPlanRepository
        );

        $command = new RentalSpaceGetDetailRentalPlanCommand($rentalSpaceId, $rentalPlanId);

        try {
            $rentalPlans = $applicationService->handle($command);
        } catch (InvalidArgumentException|RecordNotFoundException $e) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $reservationOptions = [];
        foreach ($rentalPlans->reservationOptions as $reservationOption) {
            $reservationOptions[] = [
                'reservation_option_type_id' =>$reservationOption->reservationOptionId,
                'order_number' => $reservationOption->orderNumber
            ];
        }
        $response = [
            "id" => $rentalPlanId,
            "status" => $rentalPlans->status,
            "rental_plan_name" => $rentalPlans->planName,
            "bank_account_id" => $rentalPlans->bankAccountId,
            "commission_rate" => $rentalPlans->commissionRate,
            "rental_plan_contiguous_use_discount_rule" => $rentalPlans->rentalPlanContiguousUseDiscountRule,
            "reservation_setting_min_contiguous_duration_minutes"=> $rentalPlans->reservationSettingMinContiguousDurationMinutes,
            "reservation_setting_requiring_contiguous" => $rentalPlans->reservationSettingRequiringContiguous,
            "reservation_setting_allowing_multi_booking" => $rentalPlans->reservationSettingAllowingMultiBooking,
            "reservation_early_notice_minutes_choose_later_by_customer" => $rentalPlans->reservationEarlyNoticeMinutesChooseLaterByCustomer,
            "reservation_early_notice_minutes_paid" => $rentalPlans->reservationEarlyNoticeMinutesPaid,
            "reservation_early_notice_minutes_cash_on_site" => $rentalPlans->reservationEarlyNoticeMinutesCashOnSite,
            "reservation_early_notice_minutes_bank_transfer" => $rentalPlans->reservationEarlyNoticeMinutesBankTransfer,
            "reservation_early_notice_minutes_credit_card" => $rentalPlans->reservationEarlyNoticeMinutesCreditCard,
            "cleaningDurationMinutes" => $rentalPlans->cleaningDurationMinutes,
            "payment_method_choose_later_by_customer" => $rentalPlans->paymentMethodChooseLaterByCustomer,
            "payment_method_paid" => $rentalPlans->paymentMethodPaid,
            "payment_method_cash_on_site"=> $rentalPlans->paymentMethodCashOnSite,
            "payment_method_bank_transfer" => $rentalPlans->paymentMethodBankTransfer,
            "payment_method_credit_card" => $rentalPlans->paymentMethodCreditCard,
            "day_when_not_deny_request" => $rentalPlans->dayWhenNotDenyRequest,
            "reservation_type" => $rentalPlans->reservationType,
            "reservation_early_notice_minutes_paid_type" => $rentalPlans->reservationEarlyNoticeMinutesPaidType,
            "reservation_early_notice_minutes_cash_on_site_type" => $rentalPlans->reservationEarlyNoticeMinutesCashOnSiteType,
            "reservation_early_notice_minutes_bank_transfer_type" => $rentalPlans->reservationEarlyNoticeMinutesBankTransferType,
            "reservation_early_notice_minutes_credit_card_type" => $rentalPlans->reservationEarlyNoticeMinutesCreditCardType,
            "reservation_early_notice_minutes_choose_later_by_customer_type" => $rentalPlans->reservationEarlyNoticeMinutesChooseLaterByCustomerType,
            "rental_plan_image_url" => $rentalPlans->planImage['s3key'] ?? null,
            'reservation_options' => $reservationOptions
        ];
        return response()->json($response,200);
    }

    /**
     * Admin - Create Plan Group
     */
    public function postPlanGroup($rentalSpaceId, RentalPlanGroupRequest $request): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalPlanGroupPostApplicationService(
            $rentalSpaceRentalPlanRepository
        );
        $rentalPlanIds = [];
        if ($request->has('rental_plan_ids') && !empty($request->rental_plan_ids)) {
            $rentalPlanIds = $request->rental_plan_ids;
        }
        $command = new RentalSpaceRentalPlanGroupPostCommand(
            $rentalSpaceId,
            $request->plan_group_name,
            $rentalPlanIds
        );

        try {
            $response = $applicationService->handle($command);
        } catch (Exception $e) {
            return response()->json($e,400);
        }
        return response()->json([
           'rental_space_id' => $response->rentalSpaceId,
            'rental_space_plan_group_id' => $response->rentalSpacePlanGroupId
        ],200);
    }

    /**
     * Admin - API get all plan group
     */
    public function getRentalPlanGroupAll($rentalSpaceId): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpacePlanGroupListGetApplicationService(
            $rentalSpaceRentalPlanRepository
        );

        $command = new RentalSpacePlanGroupListGetCommand($rentalSpaceId);

        try {
            $planGroups = $applicationService->handle($command);
        } catch (Exception $e) {
            return response()->json($e,400);
        }

        $responseRentalPlanGroups = [];
        foreach ($planGroups->rentalPlanGroups as $planGroup) {
            $rentalPlans = [];
            foreach ($planGroup->rentalPlans as $plan) {
                $rentalPlans[] = [
                    'plan_id' => $plan->planId,
                    'plan_name' => $plan->planName
                ];
            }
            $responseRentalPlanGroups[] = [
                'plan_group_id' => $planGroup->planGroupId,
                'plan_group_name' => $planGroup->planGroupName,
                'status' => $planGroup->status,
                'rental_plans' => $rentalPlans
            ];
        }
        return response()->json($responseRentalPlanGroups,200);
    }

    /**
     * Admin - API Detail Plan Group
     */
    public function detailRentalPlanGroup($rentalPlanGroupId): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalPlanGroupDetailGetApplicationService(
            $rentalSpaceRentalPlanRepository
        );

        $command = new RentalSpaceRentalPlanGroupDetailGetCommand($rentalPlanGroupId);

        try {
            $planGroups = $applicationService->handle($command);
        } catch (Exception $e) {
            return response()->json($e,400);
        }
        $rentalPlans = [];
        foreach ($planGroups->planGroupResult->rentalPlans as $rentalPlan) {
            $rentalPlans[] = [
                'plan_id' => $rentalPlan->planId,
                'plan_name' => $rentalPlan->planName
            ];
        }

        return response()->json([
            'plan_group_id' => $planGroups->planGroupResult->planGroupId,
            'plan_group_name' => $planGroups->planGroupResult->planGroupName,
            'status' => $planGroups->planGroupResult->status,
            'rental_plans' => $rentalPlans
        ],200);
    }

    /**
     * PUT - API update rental plan
     */
    public function putRentalPlan($rentalPlanId, Request $request):JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalPlanPutApplicationService(
            $rentalSpaceRentalPlanRepository
        );


        $rentalPlanContiguousUseDiscountRuleCommand = [];
        if (
            $request->has('rental_plan_contiguous_use_discount_rules') &&
            !empty($request->rental_plan_contiguous_use_discount_rules)
        ){
            foreach ($request->rental_plan_contiguous_use_discount_rules as $contiguous_use_discount_rule) {
                $rentalPlanContiguousUseDiscountRuleCommand[] = new RentalPlanContiguousUseDiscountRuleCommand (
                    $contiguous_use_discount_rule['total_minute_time_of_the_frame'],
                    $contiguous_use_discount_rule['total_minute_time_of_the_frame_type'],
                    $contiguous_use_discount_rule['discount_from_total_amount'],
                    $contiguous_use_discount_rule['discount_from_total_amount_type']
                );
            }
        }

        $rentalPlanReservationOptions = [];
        if ($request->has('reservation_options') && !empty($request->reservation_options)) {
            foreach ($request->reservation_options as $reservation_option) {
                $rentalPlanReservationOptions[] = new RentalPlanReservationOptionTypeCommand(
                    $reservation_option['reservation_option_id'],
                    $reservation_option['order_number'],
                );
            }
        }

        $command = new RentalSpaceRentalPlanPutCommand(
            $rentalPlanId,
            $request['status'],
            $request['plan_name'],
            $request['reservation_type'] ?? 'reservation-request',
            $request['day_when_not_deny_request'],
            $request['payment_method_creditCard'],
            $request['payment_method_bankTransfer'],
            $request['payment_method_cashOnSite'],
            $request['payment_method_paid'],
            $request['payment_method_chooseLaterByCustomer'],
            $request['bank_account_id'],
            $request['cleaning_duration_minutes'],
            $request['reservation_early_notice_minutes_creditCard'],
            $request['reservation_early_notice_minutes_creditCard_type'],
            $request['reservation_early_notice_minutes_bankTransfer'],
            $request['reservation_early_notice_minutes_bankTransfer_type'],
            $request['reservation_early_notice_minutes_cashOnSite'],
            $request['reservation_early_notice_minutes_cashOnSite_type'],
            $request['reservation_early_notice_minutes_paid'],
            $request['reservation_early_notice_minutes_paid_type'],
            $request['reservation_early_notice_minutes_chooseLaterByCustomer'],
            $request['reservation_early_notice_minutes_chooseLaterByCustomer_type'],
            $request['reservation_setting_allowing_multi_booking'],
            $request['reservation_setting_requiring_contiguous'],
            $request['reservation_setting_min_contiguous_duration_minutes'],
            $rentalPlanContiguousUseDiscountRuleCommand,
            $request['commission_rate'],
            $rentalPlanReservationOptions
        );
        $rentalPlan = $applicationService->handle($command);

        if ($request->has('image') && !empty($request->image)) {
            $allowedFileExtension=['jpg','jpeg','png','bmp'];
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $checkExtension = in_array($extension,$allowedFileExtension);

            if(!$checkExtension) {
                return response()->json(['invalid_file_format'], 422);
            }

            $informationImage = getimagesize($file);
            $path = $file->store('public/images');

            $rentalPlanImageInformation = new RentalPlanImageInformationCommand(
                $path,
                $informationImage[1],
                $informationImage[0],
                filesize($file),
                $extension
            );
            $applicationService->uploadImage($rentalPlanId,$rentalPlanImageInformation);
        }

        return response()->json([
            'rental_plan_id' => $rentalPlanId
        ], 200);
    }


    /**
     * Admin - Update Plan Group
     */
    public function updatePlanGroup($rentalPlanGroupId, RentalPlanGroupRequest $request): JsonResponse
    {
        $rentalSpaceRentalPlanRepository = new RentalSpaceRentalPlanRepository();
        $applicationService = new RentalSpaceRentalPlanGroupPutApplicationService(
            $rentalSpaceRentalPlanRepository
        );
        $plans = [];
        if ($request->has('plans') && !empty($request->plans)) {
            foreach ($request->plans as $plan) {
                $plans[] = new RentalSpaceRentalPlanInPlanGroup(
                    $plan['plan_id'],
                    $plan['status']
                );
            }
        }
        $command = new RentalSpaceRentalPlanGroupPutCommand(
            $rentalPlanGroupId,
            $request->plan_group_name,
            $request->plan_group_status ?? 'active',
            $plans
        );

        try {
            $response = $applicationService->handle($command);
        } catch (Exception $e) {
            return response()->json($e,400);
        }
        return response()->json([
            'rental_space_plan_group_id' => $response->rentalSpacePlanGroupId
        ],200);
    }
}
