<?php

namespace App\Bundle\CustomerBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;

final class CustomerManageGetApplicationService
{
    /**
     * @var \App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository
     */
    private ICustomerRepository $customerRepository;

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository $customerRepository customerRepository
     */
    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Application\CustomerManageGetCommand $command command
     * @return \App\Bundle\CustomerBundle\Application\CustomerManageGetResult
     */
    public function handle(CustomerManageGetCommand $command): CustomerManageGetResult
    {
        $customerId = new CustomerId($command->customerId);
        $result = $this->customerRepository->findById($customerId);
        if (!$result) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new CustomerManageGetResult(
            $result->getCustomerId()->getValue(),
            $result->isActive(),
            $result->getCustomerType()->getValue(),
            $result->getGenderType()->getValue(),
            $result->getCreationTime()->getTimeStamps(),
            $result->getEmail(),
            $result->getFirstName(),
            $result->getLastName(),
            $result->getFirstNameKana(),
            $result->getLastNameKana(),
            $result->getPhoneNumber(),
            $result->getAddress(),
            $result->getBirthday() ? $result->getBirthday()->getTimeStamps() : null,
            $result->getNumberOfReviews(),
            $result->getTotalPriceSansTax(),
            $result->getCompanyName(),
            $result->getCompanyNameKana(),
            null,
            $result->isReceivingReservationEmails(),
            null
        );
    }
}
