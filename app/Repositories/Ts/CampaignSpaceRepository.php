<?php

namespace App\Repositories\Ts;

use App\Models\TsCampaignSpace;
use App\Repositories\AbstractBaseRepository;

class CampaignSpaceRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(TsCampaignSpace $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $idCampaign
     *
     * @return array
     */
    public function getIdCampaign($idCampaign): array
    {
        $query = $this->model->where('ts_campaign_id', $idCampaign)->pluck('id');

        return $query->toArray();
    }
}
