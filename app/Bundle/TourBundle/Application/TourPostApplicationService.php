<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TourBundle\Domain\Model\ChoiceDate;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\Tour;
use App\Bundle\TourBundle\Domain\Model\TourStatus;
use App\Bundle\TourBundle\Domain\Model\UserViewFlg;
use App\Models\RentalSpace;
use DateTime;
use Illuminate\Support\Facades\DB;

final class TourPostApplicationService
{
    /**
     * @var ITourRepository
     */
    private ITourRepository $tourRepository;

    /**
     * TourPostApplicationService constructor.
     * @param ITourRepository $tourRepository
     */
    public function __construct(
        ITourRepository $tourRepository
    )
    {
        $this->tourRepository = $tourRepository;
    }

    /**
     * @param TourPostCommand $tourPostCommand
     * @return TourPostResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle(TourPostCommand $tourPostCommand): TourPostResult
    {
        $rentalSpace = RentalSpace::findOrFail($tourPostCommand->rentalSpaceId)->toArray();
        $organizationId = $rentalSpace['organization_id'];
        $tour = new Tour(
            null,
            new CustomerId($tourPostCommand->customerId),
            new ChoiceDate(
                new DateTime($tourPostCommand->firstChoiceDate),
                new DateTime($tourPostCommand->firstChoiceTime),
            ),
            new ChoiceDate(
                !empty($tourPostCommand->secondChoiceDate) ? new DateTime($tourPostCommand->secondChoiceDate) : null,
                !empty($tourPostCommand->secondChoiceTime) ? new DateTime($tourPostCommand->secondChoiceTime) : null,
            ),
            new ChoiceDate(
                !empty($tourPostCommand->thirdChoiceDate) ? new DateTime($tourPostCommand->thirdChoiceDate) : null,
                !empty($tourPostCommand->thirdChoiceTime) ? new DateTime($tourPostCommand->thirdChoiceTime) : null,
            ),
            new ChoiceDate(
                !empty($tourPostCommand->fourthChoiceDate) ? new DateTime($tourPostCommand->fourthChoiceDate) : null,
                !empty($tourPostCommand->fourthChoiceTime) ? new DateTime($tourPostCommand->fourthChoiceTime) : null
            ),
            null,
            null,
            null,
            new RentalSpaceId($tourPostCommand->rentalSpaceId),
            new OrganizationId($organizationId),
            null,
            TourStatus::fromStatus(TourStatus::WAIT_FOR_REPLY),
            $tourPostCommand->usePlansDate,
            $tourPostCommand->usePlansPeople,
            $tourPostCommand->usePurpose,
            $tourPostCommand->usePurposeDetail,
            $tourPostCommand->checklist,
            null,
            null,
            null,
            UserViewFlg::fromStatus(UserViewFlg::SHOW)
        );

        DB::beginTransaction();
        try {
            $tourId = $this->tourRepository->createTour($tour);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new TourPostResult(
            $tourId->getValue()
        );
    }

}

