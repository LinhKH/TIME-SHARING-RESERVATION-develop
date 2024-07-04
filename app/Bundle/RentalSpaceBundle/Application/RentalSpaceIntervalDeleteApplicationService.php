<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalIntervalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceIntervalDeleteApplicationService
{
    /**
     * Rental Space Interval Repository
     *
     * @var IRentalSpaceRentalIntervalRepository
     */
    private IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * @var IRentalSpaceRentalPlanRepository
     */
    private IRentalSpaceRentalPlanRepository $rentalPlanRepository;

    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalIntervalRepository $rentalSpaceRentalIntervalRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository,
        IRentalSpaceRentalPlanRepository $rentalPlanRepository

)
    {
        $this->rentalPlanRepository = $rentalPlanRepository;
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->rentalSpaceRentalIntervalRepository = $rentalSpaceRentalIntervalRepository;
    }

    /**
     * @param RentalSpaceIntervalDeleteCommand $command
     * @return RentalSpaceIntervalDeleteResult
     * @throws TransactionException|InvalidArgumentException
     */
    public function handle(RentalSpaceIntervalDeleteCommand $command): RentalSpaceIntervalDeleteResult
    {
        $space = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        $plan = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), new RentalPlanId($command->rentalPlanId));
        if (empty($space) || empty($plan)) {
            return new RentalSpaceIntervalDeleteResult(false);
        }

        DB::beginTransaction();
        try {
            $this->rentalSpaceRentalIntervalRepository->deleteIntervalById(
                new RentalSpaceId($command->rentalSpaceId),
                new RentalPlanId($command->rentalPlanId),
                new RentalIntervalId($command->rentalIntervalId)
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        return new RentalSpaceIntervalDeleteResult(true);
    }
}
