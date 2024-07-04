<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\PaginationResult;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\PagePaginationCriteria;

final class RentalSpaceListGetApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;


    /**
     *
     */
    public function __construct(
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    ) {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
    }

    /**
     * @param RentalSpaceListGetCommand $command command
     * @return RentalSpaceListGetResult
     */
    public function handle(RentalSpaceListGetCommand $command, $filter = null): RentalSpaceListGetResult
    {
        $rentalSpaceCommandPage = new PagePaginationCriteria(
            $command->page
        );
        [$rentalSpaces, $pagination] = $this->rentalSpaceGeneralRepository->findAll($rentalSpaceCommandPage, $filter);

        /** @var RentalSpaceListGetResult[] $rentalSpaceListGetResult */
        $rentalSpaceListGetResult = [];

        foreach ($rentalSpaces as $rentalSpace) {
            $rentalSpaceListGetResult[] = new RentalSpaceListResult(
                $rentalSpace->getRentalSpaceId()->getValue(),
                $rentalSpace->getOrganizationId()->getValue(),
                new OrganizationInformationResult(
                    $rentalSpace->getOrganizationInformation()->getName(),
                    $rentalSpace->getOrganizationInformation()->getNameFurigana()
                ),
                $rentalSpace->getStatus(),
                $rentalSpace->getTitle(),
                $rentalSpace->getDraftStep()
            );
        }

        $paginationResult = new PaginationResult(
            $pagination->getTotalPages(),
            $pagination->getPerPage(),
            $pagination->getCurrentPage(),
        );

        return new RentalSpaceListGetResult(
            $paginationResult,
            $rentalSpaceListGetResult,
        );
    }
}
