<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\PaginationResult;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\TourPagination;

final class TourListGetApplicationService
{
    /**
     * @var ITourRepository
     */
    private ITourRepository $tourRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * @var IOrganizationRepository
     */
    private IOrganizationRepository $organizationRepository;

    /**
     * @var ICustomerRepository
     */
    private ICustomerRepository $customerRepository;

    /**
     * TourListGetApplicationService constructor.
     * @param ITourRepository $tourRepository
     * @param IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
     * @param IOrganizationRepository $organizationRepository
     * @param ICustomerRepository $customerRepository
     */
    public function __construct(
        ITourRepository $tourRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository,
        IOrganizationRepository $organizationRepository,
        ICustomerRepository $customerRepository
    )
    {
        $this->tourRepository = $tourRepository;
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->organizationRepository = $organizationRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param TourListGetCommand $command
     * @return TourListGetResult
     * @throws RecordNotFoundException
     */
    public function handle(TourListGetCommand $command): TourListGetResult
    {
        $tourPagination = new TourPagination($command->page);
        [$pagination, $tours] = $this->tourRepository->findAll($tourPagination);

        $tourListGetResult = [];

        foreach ($tours as $tour) {
            $rentalSpaceGeneral = $this->rentalSpaceGeneralRepository->findById($tour->getRentalSpaceId());
            if (!$rentalSpaceGeneral) {
                throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
            }

            $organization = $this->organizationRepository->findById($tour->getOrganizationId());
            if (!$organization) {
                throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
            }

            $customer = $this->customerRepository->findById($tour->getCustomerId());
            if (!$customer) {
                throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
            }

            $tourListGetResult[] = new TourResult(
                $tour->getTourId()->getValue(),
                $customer->getFullName(),
                $rentalSpaceGeneral->getGeneralBasicSpaceNameJa(),
                $tour->getFirstChoiceDate()->asString(),
                $tour->getSecondChoiceDate()->asString(),
                $tour->getThirdChoiceDate()->asString(),
                $tour->getFixChoiceDateColumnName(),
                $tour->getFixChoiceTimeColumnName(),
                $tour->getSubstitudeFirstChoiceDate()->asString(),
                $tour->getSubstitudeThirdChoiceDate()->asString(),
                $tour->getSubstitudeSecondChoiceDate()->asString(),
                $tour->getUsePlansDate(),
                $tour->getUsePlansPeople(),
                $tour->getUsePurpose(),
                $tour->getUsePurposeDetail(),
                $tour->getChecklist(),
                $tour->getStatus()->getStatus(),
                !(empty($tour->getEntryTime())) ? $tour->getEntryTime()->format('Y-m-d H:m:i') : null
            );

        }

        return new TourListGetResult(
            new PaginationResult(
                $pagination->getTotalPage(),
                $pagination->getPerPage(),
                $pagination->getCurrentPage()
            ),
            $tourListGetResult
        );
    }
}
