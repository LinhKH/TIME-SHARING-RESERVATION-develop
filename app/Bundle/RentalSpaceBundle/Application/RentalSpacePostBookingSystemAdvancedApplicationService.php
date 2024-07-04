<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\LastMinuteDiscountType;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceBookingSystemAdvanced;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostBookingSystemAdvancedApplicationService
{
    /**
     * RentalSpaceBookingSystemRepository
     *
     * @var IRentalSpaceBookingSystemRepository
     */
    private IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository;
    private IRentalSpaceGeneralRepository $generalRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceBookingSystemRepository $rentalSpaceBookingSystemRepository,
        IRentalSpaceGeneralRepository $generalRepository
    )
    {
        $this->generalRepository = $generalRepository;
        $this->rentalSpaceBookingSystemRepository = $rentalSpaceBookingSystemRepository;
    }

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpacePostBookingSystemAdvancedCommand $command): RentalSpacePostBookingSystemAdvancedResult
    {
        $rentalSpace = $this->generalRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $rentalSpaceBookingSystem = new RentalSpaceBookingSystemAdvanced(
            new RentalSpaceId($command->rentalSpaceId),
            $command->enableLastMinuteDiscount ?? LastMinuteDiscountType::DISABLE_LAST_MINUTE_DISCOUNT ,
            $command->lastMinuteBookDiscountDaysBeforeCount,
            $command->lastMinuteBookDiscountPercentage
        );

        DB::beginTransaction();
        try {
            $rentalSpaceId = $this->rentalSpaceBookingSystemRepository->createRentalSpaceBookingSystemAdvanced($rentalSpaceBookingSystem);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        return new RentalSpacePostBookingSystemAdvancedResult(
            $rentalSpaceId->getValue()
        );
    }
}
