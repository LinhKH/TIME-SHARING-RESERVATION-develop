<?php

namespace App\Repositories\RentalSpaceCoupon;

use App\Models\RentalSpaceCoupon;
use App\Repositories\AbstractBaseRepository;

class RentalSpaceCouponRepository extends AbstractBaseRepository implements RentalSpaceCouponInterface
{
    public function __construct(RentalSpaceCoupon $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $select
     * @param null $search
     * @return array
     */
    public function handleFilterCoupon($select, $search = null): array
    {
        $query = $this->model->newQuery();

        $query->FilterCode($search);

        $query->select($select);

        return $query->get()->toArray();
    }
}
