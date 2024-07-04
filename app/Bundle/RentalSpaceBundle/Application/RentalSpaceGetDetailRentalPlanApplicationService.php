<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailRentalPlanApplicationService
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
     * @param RentalSpaceGetDetailRentalPlanCommand $command
     * @return RentalSpaceGetDetailRentalPlanResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailRentalPlanCommand $command): RentalSpaceGetDetailRentalPlanResult
    {
        $rentalPlans = $this->rentalPlanRepository->findById(
            new RentalSpaceId($command->rentalSpaceId),
            new RentalPlanId($command->rentalPlanId)
        );

        if (empty($rentalPlans)) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        [$rentalPlan, $rentalPlanImage] = $rentalPlans;
        $rentalPlanImageInformation = [];
        if (!empty($rentalPlanImage)) {
            $rentalPlanImageInformation = [
                'id' => $rentalPlanImage->getImageId(),
                's3key' => $rentalPlanImage->getS3key(),
                'height' => $rentalPlanImage->getHeight(),
                'width' => $rentalPlanImage->getWidth(),
                'length' => $rentalPlanImage->getLength(),
                'extension' => $rentalPlanImage->getExtension()
            ];
        }

        $reservationOptions = [];
        foreach ($rentalPlan->getReservationOptions() as $reservationOption) {
            $reservationOptions[] = new RentalPlanReservationOptionTypeResult(
                $reservationOption->getReservationOptionId()->getValue(),
                $reservationOption->getOrderNumber()
            );
        }

        return new RentalSpaceGetDetailRentalPlanResult(
            $rentalPlan->getStatus(),
            $rentalPlan->getPlanName(),
            $rentalPlan->getReservationType()->getValue(),
            $rentalPlan->getDayWhenNotDenyRequest(),
            $rentalPlan->getPaymentMethodCreditCard(),
            $rentalPlan->getPaymentMethodBankTransfer(),
            $rentalPlan->getPaymentMethodCashOnSite(),
            $rentalPlan->getPaymentMethodPaid(),
            $rentalPlan->getPaymentMethodChooseLaterByCustomer(),
            $rentalPlan->getBankAccountId(),
            $rentalPlan->getCleaningDurationMinutes(),
            $rentalPlan->getReservationEarlyNoticeMinutesCreditCard(),
            $rentalPlan->getReservationEarlyNoticeMinutesCreditCardType(),
            $rentalPlan->getReservationEarlyNoticeMinutesBankTransfer(),
            $rentalPlan->getReservationEarlyNoticeMinutesBankTransferType(),
            $rentalPlan->getReservationEarlyNoticeMinutesCashOnSite(),
            $rentalPlan->getReservationEarlyNoticeMinutesCashOnSiteType(),
            $rentalPlan->getReservationEarlyNoticeMinutesPaid(),
            $rentalPlan->getReservationEarlyNoticeMinutesPaidType(),
            $rentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomer(),
            $rentalPlan->getReservationEarlyNoticeMinutesChooseLaterByCustomerType(),
            $rentalPlan->getReservationSettingAllowingMultiBooking(),
            $rentalPlan->getReservationSettingRequiringContiguous(),
            $rentalPlan->getReservationSettingMinContiguousDurationMinutes(),
            $rentalPlan->getRentalPlanContiguousUseDiscountRule(),
            $rentalPlan->getCommissionRate(),
            $rentalPlanImageInformation,
            $reservationOptions
        );
    }
}
