<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceApprovalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceApproval;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePutApprovalApplicationService
{
    /**
     * RentalSpaceBookingSystemRepository
     *
     * @var IRentalSpaceApprovalRepository
     */
    private IRentalSpaceApprovalRepository $rentalSpaceApprovalRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceApprovalRepository $rentalSpaceApprovalRepository
    )
    {
        $this->rentalSpaceApprovalRepository = $rentalSpaceApprovalRepository;
    }

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpacePutApprovalCommand $command): RentalSpacePutApprovalResult
    {
        $rentalSpaceApproval = new RentalSpaceApproval(
            new RentalSpaceId($command->rentalSpaceId),
            $command->status,

        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::APPROVE),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpaceApproval,
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceApprovalRepository->updateRentalSpaceApproval($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePutApprovalResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
