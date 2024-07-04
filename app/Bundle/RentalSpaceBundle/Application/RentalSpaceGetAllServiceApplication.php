<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetAllServiceApplication
{
    /**
     * @var IRentalSpacePageAndEmailMessageRepository
     */
    private IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository;

    /**
     * RentalSpaceGetAllServiceApplication constructor.
     * @param IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
     */
    public function __construct(
        IRentalSpacePageAndEmailMessageRepository $rentalSpacePageAndEmailMessageRepository
    ) {
        $this->rentalSpacePageAndEmailMessageRepository = $rentalSpacePageAndEmailMessageRepository;
    }

    /**
     * @param RentalSpaceGetAllPageCommand $command
     * @return RentalSpaceGetAllPageResult
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpaceGetAllPageCommand $command): RentalSpaceGetAllPageResult
    {
        $rentalSpaceId = new RentalSpaceId($command->rentalSpaceId);
        $rentalSpacePages = $this->rentalSpacePageAndEmailMessageRepository->findAllPageMessageBySpaceId($rentalSpaceId);
        $rentalSpacePageAndEmailMessageObjectResults = [];
        foreach ($rentalSpacePages as $rentalSpacePage) {
            $rentalSpacePageAndEmailMessageObjectResults[] = new RentalSpacePageAndEmailMessageObjectResult(
                $rentalSpacePage->getId()->getValue(),
                $rentalSpacePage->getTitle(),
                $rentalSpacePage->getContent()
            );
        }

        return new RentalSpaceGetAllPageResult(
            $rentalSpaceId->getValue(),
            $rentalSpacePageAndEmailMessageObjectResults
        );
    }
}
