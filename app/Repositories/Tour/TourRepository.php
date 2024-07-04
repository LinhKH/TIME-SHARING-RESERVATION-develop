<?php

namespace App\Repositories\Tour;

use App\Models\RentalSpaceEav;
use App\Models\Tour;
use App\Repositories\AbstractBaseRepository;

class TourRepository extends AbstractBaseRepository implements TourInterface
{
    public function __construct(Tour $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $customerId
     * @return array
     */
    public function getListTourOfCustomer($customerId): array
    {
        $query = $this->model->whereUserId($customerId);

        $query->with(['rentalSpace' => function ($query) {
            $query->select('id');
        }]);

        $query->orderBy('id', 'desc');

        return $query->get()->toArray();
    }

    /**
     * @param int $tourId
     * @return array
     */
    public function getDetailTourOfCustomer($tourId): array
    {
        $query = $this->model->whereId($tourId)->first();

        $data = $query->toArray();
        if (empty($data['rental_space_id'])) {
            return  $data;
        }

        return $this->addNameSpace($data);
    }

    /**
     * @param $data
     * @return array
     */
    public function addNameSpace($data): array
    {
        $query = RentalSpaceEav::where('namespace', $data['rental_space_id'])->where('attribute', 'generalBasicSpaceNameJa')->first()->toArray();
        $data['namespace'] = $query['value'];

        return $data;
    }
}
