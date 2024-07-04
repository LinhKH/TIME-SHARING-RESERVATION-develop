<?php


namespace App\Repositories\RentalSpaceUsePurpose;

use App\Models\RentalSpaceUsePurpose;
use App\Repositories\AbstractBaseRepository;

class RentalSpaceUsePurposeRepository extends AbstractBaseRepository implements RentalSpaceUsePurposeInterface
{
    public function __construct(RentalSpaceUsePurpose $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public function getListPurposeUse(): array
    {
        $query = $this->model->newQuery();
        $query->where('active', 1)->with('rentalSpaceUsePurposeEavs');

        return $query->get()->toArray();
    }
}

