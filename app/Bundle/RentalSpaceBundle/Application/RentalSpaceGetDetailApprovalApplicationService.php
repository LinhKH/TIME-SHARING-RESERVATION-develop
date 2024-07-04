<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceApprovalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailApprovalApplicationService
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
     * Detail Approval
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailApprovalCommand $command): RentalSpaceGetDetailApprovalResult
    {
        $approvals = $this->rentalSpaceApprovalRepository->findBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (!$approvals) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpaceGetDetailApprovalResult(
            $approvals->getRentalSpaceId(),
            $approvals->getStatus()
        );
    }
}
