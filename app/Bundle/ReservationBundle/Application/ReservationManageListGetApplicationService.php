<?php

namespace App\Bundle\ReservationBundle\Application;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Domain\Model\PaginationResult;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\ReservationBundle\Domain\Model\IReservationRepository;
use App\Bundle\ReservationBundle\Domain\Model\ReservationCriteria;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use Exception;

final class ReservationManageListGetApplicationService
{
    /**
     * Reservation Repository
     *
     * @var IReservationRepository
     */
    private IReservationRepository $reservationRepository;

    /**
     * Rental Space General Repository
     *
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * Customer Repository
     *
     * @var ICustomerRepository
     */
    private ICustomerRepository $customerRepository;

    /**
     * User Repository
     *
     * @var IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * Construct
     */
    public function __construct(
        IReservationRepository $reservationRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository,
        ICustomerRepository $customerRepository,
        IUserRepository $userRepository
    )
    {
        $this->reservationRepository = $reservationRepository;
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function handle(ReservationManageListGetCommand $command): ReservationManageListGetResult
    {
        $reservationCommandPage = new ReservationCriteria(
            $command->page
        );
        [$reservationManages, $pagination] = $this->reservationRepository->findAll($reservationCommandPage);
        $paginationResult = new PaginationResult(
            $pagination->getTotalPages(),
            $pagination->getPerPage(),
            $pagination->getCurrentPage(),
        );
        $reservationManageResponse = [];
        foreach ($reservationManages->getReservationManages() as $reservationManage) {
            $customer = $this->customerRepository->findById($reservationManage->getCustomerId());
            $rentalSpaceGeneral = $this->rentalSpaceGeneralRepository->findById($reservationManage->getRentalSpaceId());
            $user = $this->userRepository->findById($reservationManage->getUserId());

            $reservationManageResponse[] = new ReservationManageResult(
                $reservationManage->getReservationId()->getValue(),
                new ReservationManageUserResult(
                    $reservationManage->getCustomerId()->getValue(),
                    $customer->getFirstName(),
                    $customer->getLastName()
                ),
                new ReservationManageRentalSpaceResult(
                    $reservationManage->getRentalSpaceId()->getValue(),
                    $rentalSpaceGeneral->getGeneralBasicSpaceNameJa()
                ),
                $reservationManage->getUsePurposeCategory(),
                $reservationManage->getDateOfUse()->getDate(),
                $reservationManage->getSettingTimeRange()->getStartTime()->format(DateTimeConst::FORMAT_HI),
                $reservationManage->getSettingTimeRange()->getEndTime()->format(DateTimeConst::FORMAT_HI),
                $reservationManage->getStatus(),
                $reservationManage->getRegisterDateTime()->getDateTime(),
                new ReservationManageCouponResult(
                    $reservationManage->getCouponId(),
                    $reservationManage->getCouponName(),
                    $reservationManage->getCouponDiscountPercentage()
                ),
                new ReservationManageUserResult(
                    $reservationManage->getUserId()->getValue(),
                    $user->getFirstName(),
                    $user->getLastName()
                ),
            );
        }

        return new ReservationManageListGetResult(
            $paginationResult,
            $reservationManageResponse
        );
    }
}
