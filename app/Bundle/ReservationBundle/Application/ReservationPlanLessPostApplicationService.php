<?php

namespace App\Bundle\ReservationBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\ReservationBundle\Domain\Model\DateOfUse;
use App\Bundle\ReservationBundle\Domain\Model\IReservationRepository;
use App\Bundle\ReservationBundle\Domain\Model\PlanLessBusinessStructure;
use App\Bundle\ReservationBundle\Domain\Model\PlanLessCouponDistCount;
use App\Bundle\ReservationBundle\Domain\Model\PlanLessProxyReservationType;
use App\Bundle\ReservationBundle\Domain\Model\Reservation;
use App\Bundle\ReservationBundle\Domain\Model\ReservationPlanLess;
use App\Bundle\ReservationBundle\Domain\Model\ReservationStatusType;
use App\Bundle\ReservationBundle\Domain\Model\SettingTimeRange;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class ReservationPlanLessPostApplicationService
{

    /**
     * Reservation Repository
     *
     * @var IReservationRepository
     */
    private IReservationRepository $reservationRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $generalRepository;

    /**
     * @var ICustomerRepository
     */
    private ICustomerRepository $customerRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceGeneralRepository $generalRepository,
        ICustomerRepository           $customerRepository,
        IReservationRepository        $reservationRepository
    )
    {
        $this->generalRepository = $generalRepository;
        $this->reservationRepository = $reservationRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws Exception
     */
    public function handle(ReservationPlanLessPostCommand $command): ReservationPlanLessPostResult
    {
        $rentalSpace = $this->generalRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $customer = $this->customerRepository->findByEmail($command->customerEmail);
        if (empty($customer)) {
            throw new RecordNotFoundException('「お客様情報・メールアドレス」レコードが存在していません');
        }

        $reservation = new Reservation(
            new RentalSpaceId($command->rentalSpaceId),
            null,
            $customer->getCustomerId(),
            new ReservationPlanLess(
                null,
                PlanLessProxyReservationType::fromValue($command->proxyReservationType),
                new DateOfUse(
                    new DateTime($command->day)
                ),
                new SettingTimeRange(
                    new DateTime($command->planLessStartTime),
                    new DateTime($command->planLessEndTime)
                ),
                $command->peopleCount,
                PlanLessBusinessStructure::fromValue($command->businessStructure),
                $command->usePurposeCategory,
                $command->usePurposeForOther,
                $command->totalPriceOverrideSansTax,
                $command->limitedDiscountPriceSansTax,
                $command->discount,
                new PlanLessCouponDistCount(
                    $command->couponId,
                    $command->couponName
                ),
                $command->memoOwner,
                $command->memoCustomer
            ),
            null,
            ReservationStatusType::fromType(ReservationStatusType::RESERVARION_STATUS_PENDING)
        );

        DB::beginTransaction();
        try {
            $reservationResponse = $this->reservationRepository->createReservationPlanLess($reservation);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new TransactionException('更新できませんでした');
        }
        return new ReservationPlanLessPostResult(
            $reservationResponse->getValue()
        );
    }
}
