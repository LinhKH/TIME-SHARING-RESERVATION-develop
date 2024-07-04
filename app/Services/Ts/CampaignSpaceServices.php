<?php

namespace App\Services\Ts;

use App\Repositories\Ts\CampaignSpaceRepository;

class CampaignSpaceServices
{
    protected CampaignSpaceRepository $campaignSpaceRepository;

    public function __construct(CampaignSpaceRepository $campaignSpaceRepository)
    {
        $this->campaignSpaceRepository = $campaignSpaceRepository;
    }
}
