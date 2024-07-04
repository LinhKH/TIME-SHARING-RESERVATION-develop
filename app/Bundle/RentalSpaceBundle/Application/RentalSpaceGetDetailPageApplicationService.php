<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailPageApplicationService
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
    public function handle(RentalSpaceGetDetailPageCommand $command): RentalSpaceGetDetailPageResult
    {
        $pages = $this->pageAndEmailMessageRepository->findPageBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (!$pages) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpaceGetDetailPageResult(
            $pages->getRentalSpaceId(),
            $pages->getTermsOfUse(),
            $pages->getCancellationPolicy(),
            $pages->getProhibitedMatter(),
            $pages->getFaq(),
            $pages->getNotices(),
            $pages->getNoteFromSpace(),
            $pages->getQuestionsFromSpace()
        );
    }
}
