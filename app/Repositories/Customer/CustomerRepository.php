<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\AbstractBaseRepository;

class CustomerRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    /**
     * @param null $search
     * @param int $perPage
     * @return object
     */
    public function getListCustomer($search = null, int $perPage): object
    {
        $query = $this->model->orderBy('id', 'DESC');

        $query->FilterName($search);
        $query->FilterEmail($search);
        $query->FilterPhoneNumber($search);
        $query->FilterAddress($search);
        $query->FilterEmailStatus($search);
        $query->FilterPhoneNumberStatus($search);
        $query->FilterRegistrationDate($search);

        return $query->paginate($perPage);
    }

    /**
     * @param $select
     * @param null $search
     * @return array
     */
    public function handleFilterCustomer($select, $search = null): array
    {
        $query = $this->model->newQuery();

        $query->FilterEmail($search);

        $query->select($select);

        return $query->get()->toArray();
    }

    /**
     * @param int $customerId
     * @return array
     */
    public function getInfoCustomer($customerId): array
    {
        $query = $this->model->whereId($customerId)->first();

        return $query->toArray();
    }
}
