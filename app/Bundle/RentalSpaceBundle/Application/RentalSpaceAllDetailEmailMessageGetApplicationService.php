<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceAllDetailEmailMessageGetApplicationService
{
    private IRentalSpacePageAndEmailMessageRepository $retalSpacePageAndEmailMessageRepository;

    public function __construct(
        IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
    )
    {
        $this->retalSpacePageAndEmailMessageRepository = $rentalSpacePageAndEmailMessageRepository;
    }

    /**
     * @param RentalSpaceAllDetailEmailMessageGetCommand $command
     * @return RentalSpaceAllDetailEmailMessageGetResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceAllDetailEmailMessageGetCommand $command): RentalSpaceAllDetailEmailMessageGetResult
    {
        $rentalSpaceId = new RentalSpaceId($command->rentalSpaceId);
        $rentalSpaceEmailMessage = $this->retalSpacePageAndEmailMessageRepository->findAllEmailMessageBySpaceId($rentalSpaceId);

        $rentalSpacePageAndEmailMessageObjectResults = [];
        if (!empty($rentalSpaceEmailMessage)) {
            foreach ($rentalSpaceEmailMessage as $value) {
                $rentalSpacePageAndEmailMessageObjectResults[] = new RentalSpacePageAndEmailMessageObjectResult(
                    $value->getId()->getValue(),
                    $value->getTitle(),
                    $value->getContent()
                );
            }
        }

        return new RentalSpaceAllDetailEmailMessageGetResult(
            $rentalSpaceId->getValue(),
            $rentalSpacePageAndEmailMessageObjectResults
        );
    }
}
