<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpacePageAndEmailMessage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class RentalSpacePageAndEmailMessageApplicationService
{
    /**
     * RentalSpacePageAndMessageRepository
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
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function handle(RentalSpacePageAndEmailMessageCommand $command): RentalSpacePageAndEmailMessageResult
    {
        $rentalSpacePageAndEmailMessage = new RentalSpacePageAndEmailMessage(
            new RentalSpaceId($command->rentalSpaceId),
            $command->termOfUse,
            $command->cancellationPolicy,
            $command->prohibitedMatter,
            $command->faq,
            $command->notices,
            $command->noteFromSpace,
            $command->questionsFromSpace,
            $command->reservationCreation,
            $command->reservationAfterPayment,
            $command->tomorrowsReminder,
            $command->tourComplete
        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::PAGE_AND_EMAIL_MESSAGE),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $rentalSpacePageAndEmailMessage,
            null,
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->pageAndEmailMessageRepository->createRentalSpacePageAndEmailMessage($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePageAndEmailMessageResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
