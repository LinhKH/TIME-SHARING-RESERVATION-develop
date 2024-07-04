<?php

namespace App\Bundle\CustomerBundle\Application;

use App\Bundle\Common\Application\PaginationResult;
use App\Bundle\CustomerBundle\Domain\Model\CustomerFilter;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use Carbon\Carbon;

final class CustomerManageListGetApplicationService
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
    )
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Application\CustomerManageListGetCommand $command command
     * @return \App\Bundle\CustomerBundle\Application\CustomerManageListGetResult
     */
    public function handle(CustomerManageListGetCommand $command): CustomerManageListGetResult
    {
        $customersFilter = new CustomerFilter(
            $command->created_at,
            $command->total_fee,
            $command->number_of_reviews,
            $command->firstName,
            $command->email,
            $command->address,
            $command->membership_type,
            $command->phoneNumber,
            $command->emailStatus,
            $command->phoneNumberStatus,
            $command->e_mail_magazine, // 0:active, 1:deactive
            $command->status,
            $command->registrationDateStart,
            $command->registrationDateEnd
        );
        [$results, $pagination] = $this->customerRepository->findAll($customersFilter);
        $customers = [];

        foreach ($results as $result) {
            $customers[] = new CustomerManageResult(
                $result->getCustomerId()->getValue(),
                $result->isActive(),
                $result->getCustomerType()->getValue(),
                $result->getGenderType()->getValue(),
                /*date("Y-m-d h:i:s", $result->getCreationTime()->getTimeStamps()),*/
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
            );
        }

        $paginationResult = new PaginationResult(
            $pagination->getTotalPages(),
            $pagination->getPerPage(),
            $pagination->getCurrentPage(),
        );

        return new CustomerManageListGetResult(
            $customers,
            $paginationResult
        );
    }
}
