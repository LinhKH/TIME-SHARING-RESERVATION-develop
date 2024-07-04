<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailEmailMessageApplicationService
{
    /**
     * IRentalSpacePageAndEmailMessageRepository
     *
     * @var IRentalSpacePageAndEmailMessageRepository
     *
     */
    private IRentalSpacePageAndEmailMessageRepository $pageAndEmailMessageRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpacePageAndEmailMessageRepository $pageAndEmailMessageRepository
    )
    {
        $this->pageAndEmailMessageRepository = $pageAndEmailMessageRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailEmailMessageCommand $command): RentalSpaceGetDetailEmailMessageResult
    {
        $emailMessage = $this->pageAndEmailMessageRepository->findEmailMessageBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (!$emailMessage) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpaceGetDetailEmailMessageResult(
            $emailMessage->getRentalSpaceId(),
            $emailMessage->getReservationCreation(),
            $emailMessage->getReservationAfterPayment(),
            $emailMessage->getTomorrowsReminder(),
            $emailMessage->getTourComplete()
        );
    }
}
