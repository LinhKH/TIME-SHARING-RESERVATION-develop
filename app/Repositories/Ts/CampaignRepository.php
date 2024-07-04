<?php

namespace App\Repositories\Ts;

use App\Models\RentalSpace;
use App\Models\RentalSpaceEav;
use App\Models\TsCampaign;
use App\Repositories\AbstractBaseRepository;

class CampaignRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(TsCampaign $model)
    {
        $this->model = $model;
    }

    /**
     * @param null $search
     * @param int $limit
     *
     * @return object
     */
    public function getListTsCampaign($search = null, $limit): object
    {
        $query = $this->model->orderBy('id', 'DESC');

        $query->FilterTitle($search);

        return $query->paginate($limit);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getDetailTsCampaign(int $id): array
    {
        $query = $this->model->whereId($id)->with('tsCampaignSpace')->first();

        return $query->toArray();
    }

    /**
     * @param int $idSpace
     *
     * @return array
     */
    public function getNameSpace(int $idSpace): array
    {
        $idRentalSpace = RentalSpace::whereId($idSpace)->first('id');

        $rentalSpaceEav = RentalSpaceEav::where('attribute', 'generalBasicSpaceNameJa')->where('namespace', $idRentalSpace->id)->first('value');

        return $rentalSpaceEav->toArray();
    }
}
