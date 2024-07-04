<?php


namespace App\Repositories\FooterLinkEav;

use App\Models\FooterLinkEav;
use App\Repositories\AbstractBaseRepository;

class FooterLinkEavRepository extends AbstractBaseRepository implements FooterLinkEavInterface
{
    public function __construct(FooterLinkEav $model)
    {
        parent::__construct($model);
    }

}
