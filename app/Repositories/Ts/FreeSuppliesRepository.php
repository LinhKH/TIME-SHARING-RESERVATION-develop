<?php

namespace App\Repositories\Ts;

use App\Models\TsFreeSupplie;
use App\Repositories\AbstractBaseRepository;

class FreeSuppliesRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(TsFreeSupplie $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $filter
     * @param int $limit
     *
     * @return object
     */
    public function getListFreeSupplies($filter, $limit): object
    {
        $query = $this->model->whereStatus(TsFreeSupplie::TS_FREESUPPLIES_STATUS_ACTIVE);

        $query->FilterTitle($filter);

        $query->orderByDesc('id');

        return $query->paginate($limit);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getDetailFreeSupplies(int $id): array
    {
        $query = $this->model->whereId($id)->first();

        return $query->toArray();
    }

    public function handleCheckName($name)
    {
        $query = $this->model->where('name', $name)->first('id');

        return $query;
    }

    public function handleCheckSlug($slug)
    {
        $query = $this->model->where('slug', $slug)->first('id');

        return $query;
    }
}
