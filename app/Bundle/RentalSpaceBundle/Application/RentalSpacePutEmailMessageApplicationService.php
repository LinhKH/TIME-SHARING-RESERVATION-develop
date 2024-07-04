<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\DomainException;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailId;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailMessageType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGetPageAndEmailMessageAllInformation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePutEmailMessageApplicationService
{
    /**
     * @var IRentalSpacePageAndEmailMessageRepository
     */
    private IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository;

    /**
     * RentalSpacePutEmailMessageApplicationService constructor.
     * @param IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
     */
    public function __construct(IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository)
    {
        $this->rentalSpacePageAndEmailMessageRepository = $rentalSpacePageAndEmailMessageRepository;
    }

    /**
     * @param RentalSpacePutEmailMessageCommand $command
     * @return RentalSpacePutEmailMessageResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(RentalSpacePutEmailMessageCommand $command): RentalSpacePutEmailMessageResult
    {
        $rentalSpaceGetPageAndEmailMessageAllInformation = new RentalSpaceGetPageAndEmailMessageAllInformation(
            new PageAndEmailId($command->emailMessageId),
            null,
            $command->content,
            PageAndEmailMessageType::fromType(PageAndEmailMessageType::EMAIL_MESSAGE)
        );

        DB::beginTransaction();
        try {
            $emailMessageId = $this->rentalSpacePageAndEmailMessageRepository->updateEmailMessageById($rentalSpaceGetPageAndEmailMessageAllInformation);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        if (!$emailMessageId) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpacePutEmailMessageResult(
            $emailMessageId->getValue()
        );
    }
}
