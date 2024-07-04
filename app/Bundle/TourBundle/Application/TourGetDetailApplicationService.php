<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\TourId;

final class TourGetDetailApplicationService
{
    /**
     * @var ITourRepository
     */
    private ITourRepository $tourRepository;

    /**
     * @var ICustomerRepository
     */
    private ICustomerRepository $customerRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * TourGetDetailApplicationService constructor.
     * @param ITourRepository $tourRepository
     * @param ICustomerRepository $customerRepository
     * @param IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
     */
    public function __construct(
        ITourRepository $tourRepository,
        ICustomerRepository $customerRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->customerRepository = $customerRepository;
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
    }

    /**
     * @param TourGetDetailCommand $command
     * @return TourGetDetailResult
     * @throws RecordNotFoundException
     * @throws InvalidArgumentException
     */
    public function handle(TourGetDetailCommand $command): TourGetDetailResult
    {
        $tour = $this->tourRepository->findById(new TourId($command->tourId));
        if (!$tour) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $customerId = $tour->getCustomerId();
        $customer = $this->customerRepository->findById($customerId);

        if (!$customer) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $rentalSpaceGeneral = $this->rentalSpaceGeneralRepository->findById($tour->getRentalSpaceId());

        return new TourGetDetailResult(
            $tour->getTourId()->getValue(),
            $rentalSpaceGeneral->getGeneralBasicSpaceNameJa(),
            $tour->getCustomerId()->getValue(),
            $tour->getRentalSpaceId()->getValue(),
            $tour->getOrganizationId()->getValue(),
            $tour->getChecklist(),
            $tour->getEntryTime()->format('Y-m-d H:m:i'),
            $tour->getFirstChoiceDate()->getDate(),
            $tour->getFirstChoiceDate()->getTime(),
            $tour->getSecondChoiceDate()->getDate(),
            $tour->getSecondChoiceDate()->getTime(),
            $tour->getThirdChoiceDate()->getDate(),
            $tour->getThirdChoiceDate()->getTime(),
            $tour->getFourthChoiceDate()->getDate(),
            $tour->getFourthChoiceDate()->getTime(),
            $tour->getSubstitudeFirstChoiceDate()->getDate(),
            $tour->getSubstitudeFirstChoiceDate()->getTime(),
            $tour->getSubstitudeSecondChoiceDate()->getDate(),
            $tour->getSubstitudeSecondChoiceDate()->getTime(),
            $tour->getSubstitudeThirdChoiceDate()->getDate(),
            $tour->getSubstitudeThirdChoiceDate()->getTime(),
            $tour->getStatus()->getStatus(),
            $tour->getFixChoiceDateColumnName(),
            $tour->getFixChoiceTimeColumnName(),
            $tour->getNoReason(),
            $tour->getUsePlansDate(),
            $tour->getUsePlansPeople(),
            $tour->getUsePurpose(),
            $tour->getUsePurposeDetail(),
            $tour->getUserViewFlg()->getStatus(),
            $customer->getCustomerType()->getType(),
            $customer->getGenderType()->getType(),
            $customer->getCompanyName(),
            $customer->getCompanyNameKana(),
            $customer->getFullName(),
            !empty($customer->getBirthday()) ? $customer->getBirthday()->getDate() : null,
            $customer->getPhoneNumber(),
            $customer->getEmail(),
            $customer->getAddress(),
            !empty($customer->getCreationTime()) ? $customer->getCreationTime()->getDateTime() : null,
            $customer->getCustomerId()->getValue()
        );
    }
}
