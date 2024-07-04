<?php
namespace App\Bundle\CustomerBundle\Domain\Model;

interface ICustomerRepository
{
    /**
     * @return array{\App\Bundle\CustomerBundle\Domain\Model\Customer[], \App\Bundle\Common\Domain\Model\Pagination}
     */
    public function findAll(CustomerFilter $customerFilter): array;

    /**
     * @param CustomerId $customerId customerId
     * @return Customer|null
     */
    public function findById(CustomerId $customerId): ?Customer;

    /**
     * @param Customer $customer customer
     * @return CustomerId|null
     */
    public function create(Customer $customer): ?CustomerId;

    /**
     * @param Customer $customer customer
     * @return CustomerId|null
     */
    public function updateStatus(Customer $customer): ?CustomerId;

    /**
     * @param string $email
     * @return Customer|null
     */
    public function findByEmail(string $email): ?Customer;

    /**
     * @param Customer $customer customer
     * @return CustomerId|null
     */
    public function updateReceivingReservationEmail(Customer $customer): ?CustomerId;
}
