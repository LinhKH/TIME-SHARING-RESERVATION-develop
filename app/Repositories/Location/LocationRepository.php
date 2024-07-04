<?php

namespace App\Repositories\Location;

use App\Models\Area;
use App\Repositories\AbstractBaseRepository;

class LocationRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(Area $model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getListLocation(): array
    {
        $query = $this->model->whereStatus(Area::LOCATION_STATUS_ACTIVE)->get();

        return $query->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getDetailLocation(int $id): array
    {
        $query = $this->model->whereId($id)->first();

        return $query->toArray();
    }

    public function handleCheckNameLocation($name)
    {
        $query = $this->model->where('name', $name)->first('id');

        return $query;
    }

    public function handleCheckSlugLocation($slug)
    {
        $query = $this->model->where('slug', $slug)->first('id');

        return $query;
    }
}
