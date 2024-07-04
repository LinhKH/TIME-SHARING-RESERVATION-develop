<?php


namespace App\Repositories\FooterLinkCategoryEav;

use App\Models\FooterLinkCategoryEav;
use App\Repositories\AbstractBaseRepository;

class FooterLinkCategoryEavRepository extends AbstractBaseRepository implements FooterLinkCategoryEavInterface
{
    public function __construct(FooterLinkCategoryEav $model)
    {
        parent::__construct($model);
    }

}

