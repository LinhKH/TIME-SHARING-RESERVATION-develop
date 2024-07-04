<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanContiguousUseDiscountRule;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanImageId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanImageInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanReservationOptionType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanStatusType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlan;
use App\Bundle\RentalSpaceBundle\Domain\Model\ReservationOptionTypeId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceRentalPlanPutApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalPlanRepository
     */
    private IRentalSpaceRentalPlanRepository $rentalPlanRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalPlanRepository $rentalPlanRepository
    )
    {
        $this->rentalPlanRepository = $rentalPlanRepository;
    }


    /**
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(RentalSpaceRentalPlanPutCommand $command): RentalSpaceRentalPlanPutResult
    {
        $rentalPlanContiguousUseDiscountRules = [];
        foreach ($command->rentalPlanContiguousUseDiscountRuleCommand as $rentalPlanContiguousUseDiscountRule) {
            $rentalPlanContiguousUseDiscountRules[] = new RentalPlanContiguousUseDiscountRule(
                $rentalPlanContiguousUseDiscountRule->totalMinuteTimeOfTheFrame,
                $rentalPlanContiguousUseDiscountRule->totalMinuteTimeOfTheFrameType,
                $rentalPlanContiguousUseDiscountRule->discountFromTotalAmount,
                $rentalPlanContiguousUseDiscountRule->discountFromTotalAmountType
            );
        }

        $reservationOptions = [];
        foreach ($command->reservationOptions as $reservationOption) {
            $reservationOptions[] = new RentalPlanReservationOptionType(
                new ReservationOptionTypeId($reservationOption->reservationOptionId),
                $reservationOption->orderNumber
            );
        }
        $rentalSpaceRentalPlan = new RentalSpaceRentalPlan(
            null,
            new RentalPlanId($command->rentalPlanId),
            RentalPlanStatusType::fromValue($command->status)->getValue(),
            $command->planName,
            RentalPlanType::fromValue($command->reservationType),
            $command->dayWhenNotDenyRequest,
            $command->paymentMethodCreditCard,
            $command->paymentMethodBankTransfer,
            $command->paymentMethodCashOnSite,
            $command->paymentMethodPaid,
            $command->paymentMethodChooseLaterByCustomer,
            $command->bankAccountId,
            $command->cleaningDurationMinutes,
            $command->reservationEarlyNoticeMinutesCreditCard,
            $command->reservationEarlyNoticeMinutesCreditCardType,
            $command->reservationEarlyNoticeMinutesBankTransfer,
            $command->reservationEarlyNoticeMinutesBankTransferType,
            $command->reservationEarlyNoticeMinutesCashOnSite,
            $command->reservationEarlyNoticeMinutesCashOnSiteType,
            $command->reservationEarlyNoticeMinutesPaid,
            $command->reservationEarlyNoticeMinutesPaidType,
            $command->reservationEarlyNoticeMinutesChooseLaterByCustomer,
            $command->reservationEarlyNoticeMinutesChooseLaterByCustomerType,
            $command->reservationSettingAllowingMultiBooking,
            $command->reservationSettingRequiringContiguous,
            $command->reservationSettingMinContiguousDurationMinutes,
            $rentalPlanContiguousUseDiscountRules,
            $command->commissionRate,
            $reservationOptions
        );
        $rentalSpace = new RentalSpace(
            null,
           null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpaceRentalPlan,
            null,
            null,
            null,
            null
        );
        DB::beginTransaction();
        try {
            $rentalPlanId = $this->rentalPlanRepository->updateRentalPlan($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new RentalSpaceRentalPlanPutResult(
            $rentalPlanId->getValue()
        );
    }

    /** Upload Image Rental Plan
     * @param $rentalPlanId
     * @param RentalPlanImageInformationCommand $imageInformationCommand
     * @return mixed
     * @throws TransactionException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function uploadImage($rentalPlanId, RentalPlanImageInformationCommand $imageInformationCommand): bool
    {
        $rentalPlanImageInformation = new RentalPlanImageInformation(
            RentalPlanImageId::newId(),
            $imageInformationCommand->s3key,
            $imageInformationCommand->height,
            $imageInformationCommand->width,
            $imageInformationCommand->length,
            $imageInformationCommand->extension
        );
        DB::beginTransaction();
        try {
            $this->rentalPlanRepository->uploadImageRentalPlan(
                new RentalPlanId($rentalPlanId),
                $rentalPlanImageInformation
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return true;
    }
}
