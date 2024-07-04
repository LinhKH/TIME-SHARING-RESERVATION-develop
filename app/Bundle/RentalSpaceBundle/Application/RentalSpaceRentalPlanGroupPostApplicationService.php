<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceRentalPlanGroup;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceRentalPlanGroupPostApplicationService
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
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceRentalPlanGroupPostCommand $command): RentalSpaceRentalPlanGroupPostResult
    {
        $rentalPlanIds = [];
        foreach ($command->rentalPlanIds as $rentalPlanId) {
            if (!is_int($rentalPlanId)) {
                throw new InvalidArgumentException("[{$rentalPlanId}] 不正な値です。");
            }
            $rentalPlanIds[] = new RentalPlanId($rentalPlanId);
        }

        $rentalSpaceRentalPlanGroup = new RentalSpaceRentalPlanGroup(
            new RentalSpaceId($command->rentalSpaceId),
            null,
            $command->planGroupName,
            $rentalPlanIds,
            null
        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
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
            $rentalSpaceResponse = $this->rentalPlanRepository->createRentalSpaceRentalPlanGroup($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        [$rentalSpaceId, $rentalPlanGroupId] = $rentalSpaceResponse;
        return new RentalSpaceRentalPlanGroupPostResult(
            $rentalSpaceId->getValue(),
            $rentalPlanGroupId->getValue()
        );
    }
}
