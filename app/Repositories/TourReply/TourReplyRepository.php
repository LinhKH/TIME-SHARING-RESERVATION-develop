<?php

namespace App\Repositories\TourReply;

use App\Models\TourReply;
use App\Repositories\AbstractBaseRepository;

class TourReplyRepository extends AbstractBaseRepository implements TourReplyInterface
{
    public function __construct(TourReply $model)
    {
        parent::__construct($model);
    }


}
