<?php

namespace App\Repositories\Area;

use App\Models\AreaGroup;
use App\Repositories\AbstractBaseRepository;

class SmallAreaRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(AreaGroup $model)
    {
        $this->model = $model;
    }

    public function getLatestId()
    {
        return $this->model::GetLatestId();
    }

    /**
     * @return array
     */
    public function getListSmallArea(): array
    {
        $query = $this->model->whereNull('parent_id')->with(['areaGroups', 'areaGroupEavs'])->get();

        return $query->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailSmallArea(int $id): array
    {
        $query = $this->model->whereId($id)->with(['areaGroups', 'areaGroupEavs'])->first();

        return $query->toArray();
    }
}
