<?php

namespace App\Repositories\Ts;

use App\Models\TsCategorySpace;
use App\Repositories\AbstractBaseRepository;

class CategorySpaceRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(TsCategorySpace $model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getListCategorySpaces(): array
    {
        $query = $this->model->whereStatus(TsCategorySpace::TS_CATEGORY_SPACES_STATUS_ACTIVE)->get();

        return $query->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailCategorySpaces(int $id): array
    {
        $query = $this->model->whereId($id)->first();

        return $query->toArray();
    }

    public function handleCheckNameCategory($name)
    {
        $query = $this->model->where('name', $name)->first('id');

        return $query;
    }

    public function handleCheckSlugCategory($slug)
    {
        $query = $this->model->where('slug', $slug)->first('id');

        return $query;
    }
}
