<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanGroupId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanStatusType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlanInPlanGroup as RentalSpaceRentalPlanInPlanGroupDomain;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlanGroup;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceRentalPlanGroupPutApplicationService
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
     * @throws InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(RentalSpaceRentalPlanGroupPutCommand $command): RentalSpaceRentalPlanGroupPutResult
    {
        $plans = [];
        foreach ($command->plans as $plan) {
            $plans[] = new RentalSpaceRentalPlanInPlanGroupDomain(
                new RentalPlanId($plan->planId),
                RentalPlanStatusType::fromValue($plan->status)
            );
        }

        $rentalSpaceRentalPlanGroup = new RentalSpaceRentalPlanGroup(
            null,
            new RentalPlanGroupId($command->rentalPlanGroupId),
            $command->planGroupName,
            $plans,
            RentalPlanStatusType::fromValue($command->planGroupStatus)
        );
        $rentalSpace = new RentalSpace(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpaceRentalPlanGroup
        );
        DB::beginTransaction();
        try {
            $rentalPlanGroupId = $this->rentalPlanRepository->updateRentalPlanGroup($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new RentalSpaceRentalPlanGroupPutResult(
            $rentalPlanGroupId->getValue()
        );
    }
}
