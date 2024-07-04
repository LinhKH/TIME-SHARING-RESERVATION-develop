<?php


namespace App\Repositories\TrackLink;

use App\Models\TrackingLink;
use App\Repositories\AbstractBaseRepository;

class TrackLinkRepository extends AbstractBaseRepository implements TrackLinkInterface
{
    public function __construct(TrackingLink $model)
    {
        parent::__construct($model);
    }

}

