<?php


namespace App\Repositories\FooterLinkCategory;

use App\Models\FooterLinkCategory;
use App\Repositories\AbstractBaseRepository;

class FooterLinkCategoryRepository extends AbstractBaseRepository implements FooterLinkCategoryInterface
{
    public function __construct(FooterLinkCategory $model)
    {
        parent::__construct($model);
    }

}

