<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailId;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailMessageType;

final class RentalSpaceDetailPageAndEmailMessageGetApplicationService
{
    private IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository;

    /**
     * RentalSpaceDetailPageAndEmailMessageGetApplicationService constructor.
     * @param IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
     */
    public function __construct(IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository)
    {
        $this->rentalSpacePageAndEmailMessageRepository = $rentalSpacePageAndEmailMessageRepository;
    }

    /**
     * @param RentalSpaceDetailPageAndEmailMessageGetCommand $command
     * @return RentalSpaceDetailPageAndEmailMessageGetResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceDetailPageAndEmailMessageGetCommand $command): RentalSpaceDetailPageAndEmailMessageGetResult
    {
        $pageAndEmailId = new PageAndEmailId($command->pageAndEmailId);
        $pageAndEmailMessageType = PageAndEmailMessageType::fromType($command->type);
        $pageAndEmailMessageInformation = null;
        if ($pageAndEmailMessageType->isEmailMessage()) {
            $pageAndEmailMessageInformation = $this->rentalSpacePageAndEmailMessageRepository->findEmailMessageById($pageAndEmailId);
        } elseif ($pageAndEmailMessageType->isPage()) {
            $pageAndEmailMessageInformation = $this->rentalSpacePageAndEmailMessageRepository->findPageById($pageAndEmailId);
        }
        if (!$pageAndEmailMessageInformation) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        return new RentalSpaceDetailPageAndEmailMessageGetResult(
            $pageAndEmailMessageInformation->getId()->getValue(),
            $pageAndEmailMessageInformation->getTitle(),
            $pageAndEmailMessageInformation->getContent(),
            $pageAndEmailMessageType->getValue()
        );
    }
}
