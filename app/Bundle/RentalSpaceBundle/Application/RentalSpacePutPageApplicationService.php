<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailId;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailMessageType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGetPageAndEmailMessageAllInformation;
use App\Models\RentalSpaceEav;
use App\Models\RentalSpacePage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePutPageApplicationService
{
    private IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository;

    /**
     * RentalSpacePutPageApplicationService constructor.
     * @param IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
     */
    public function __construct(IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository)
    {
        $this->rentalSpacePageAndEmailMessageRepository = $rentalSpacePageAndEmailMessageRepository;
    }

    /**
     * @param RentalSpacePutPageCommand $command
     * @return RentalSpacePutPageResult
     * @throws InvalidArgumentException
     * @throws TransactionException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpacePutPageCommand $command): RentalSpacePutPageResult
    {
        $rentalSpaceGetPageAndEmailMessageAllInformation = new RentalSpaceGetPageAndEmailMessageAllInformation(
            new PageAndEmailId($command->pageId),
            null,
            $command->content,
            PageAndEmailMessageType::fromType(PageAndEmailMessageType::PAGE)
        );

        DB::beginTransaction();
        try {
            $pageId = $this->rentalSpacePageAndEmailMessageRepository->updatePageById($rentalSpaceGetPageAndEmailMessageAllInformation);

            $rentalSpacePage = RentalSpacePage::findOrFail($command->pageId);

            if ($command->title == 'term_of_use') {
                $rentalSpace = RentalSpaceEav::where('namespace', $rentalSpacePage->rental_space_id)->where('attribute', 'generalSpaceInformationTermsOfService')->first();
                if (!empty($rentalSpace)) {
                    $rentalSpace->update(['value' =>  $command->content]);
                }
            } elseif ($command->title  == 'cancellation_policy') {
                $rentalSpace = RentalSpaceEav::where('namespace', $rentalSpacePage->rental_space_id)->where('attribute', 'generalSpaceInformationCancellationPolicy')->first();
                if (!empty($rentalSpace)) {
                    $rentalSpace->update(['value' =>  $command->content]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        if (!$pageId) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpacePutPageResult(
            $pageId->getValue()
        );
    }
}
