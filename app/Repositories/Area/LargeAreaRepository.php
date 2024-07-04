<?php

namespace App\Repositories\Area;

use App\Models\AreaArea;
use App\Repositories\AbstractBaseRepository;

class LargeAreaRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(AreaArea $model)
    {
        $this->model = $model;
    }

    public function getLatestId()
    {
        return $this->model::GetLatestId();
    }

    /**
     * @param $elements
     * @param $parentId
     * @return array
     */
    public function convertListLargeArea($elements, $parentId = null): array
    {
        if (empty($elements)) {
            return [];
        }

        $query = $this->model->newQuery()->get();
        $elements = $query->toArray();

        $data = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->convertListLargeArea($elements, $element["id"]);

                if ($children) {
                    $element["children"] = $children;
                }

                $data[] = $element;
            }
        }

        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailLargeArea(int $id): array
    {
        $query = $this->model->whereId($id)->with('areaAreaEavs')->first();

        return $query->toArray();
    }
}
