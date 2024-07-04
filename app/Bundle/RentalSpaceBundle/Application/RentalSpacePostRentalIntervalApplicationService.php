<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalDateAndTime;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalInterval;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalHolidayApplicabilityType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalMultiType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalIntervalTimeFormatted;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostRentalIntervalApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository
    )
    {
        $this->rentalSpaceRentalIntervalRepository = $rentalSpaceRentalIntervalRepository;
    }

    /**
     * @param RentalSpacePostRentalIntervalCommand $command
     * @return RentalSpacePostRentalIntervalResult
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(RentalSpacePostRentalIntervalCommand $command): RentalSpacePostRentalIntervalResult
    {
        $timeFormattedDomain = new RentalSpaceRentalIntervalTimeFormatted(
            RentalSpaceRentalIntervalMultiType::fromType($command->intervalMulti),
            $command->startTimeFormatted,
            $command->endTimeFormatted
        );



        $rentalSpaceRentalInterval = new RentalSpaceRentalInterval(
            new RentalPlanId($command->rentalSpaceRentalPlanId),
            null,
            null,
            $command->applicabilityPeriods,
            RentalSpaceRentalIntervalHolidayApplicabilityType::fromType($command->holidayApplicabilityType),
            RentalSpaceRentalIntervalMultiType::fromType($command->intervalMulti),
            $timeFormattedDomain->handleTimeFormattedFrame(),
            $command->tenancyPrice,
            $command->perPersonPrice,
            $command->maxSimultaneousReservations,
            $command->maxSimultaneousPeople,
        );

        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::PLAN_CREATE_RESERVATION_FRAME),
            null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpaceRentalInterval,
            null,
            null,
            null
        );
        $rentalSpaceRentalIntervalRequest = new RentalIntervalDateAndTime(
            $command->applicabilityPeriods,
            $command->startTimeFormatted,
            $command->endTimeFormatted
        );

        $collectionInterval = $this->rentalSpaceRentalIntervalRepository->findCollectionRentalInterval($rentalSpace);
        if (!$collectionInterval->valid($rentalSpaceRentalIntervalRequest)) {
            throw new InvalidArgumentException('予約枠ごとの時間設定,曜日設定は既に登録しました。');
        }
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceRentalIntervalRepository->createRentalSpaceRentalInterval($rentalSpace);
            if (empty($rentalSpaceResponse)){
                throw new TransactionException('システムにデータが存在しません');
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePostRentalIntervalResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
