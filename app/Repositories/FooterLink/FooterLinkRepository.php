<?php


namespace App\Repositories\FooterLink;

use App\Models\FooterLink;
use App\Repositories\AbstractBaseRepository;

class FooterLinkRepository extends AbstractBaseRepository implements FooterLinkInterface
{
    public function __construct(FooterLink $model)
    {
        parent::__construct($model);
    }

}

