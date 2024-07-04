<?php

namespace App\Repositories\Ts;

use App\Models\RentalSpace;
use App\Models\RentalSpaceEav;
use App\Models\TsCampaign;
use App\Models\TsNews;
use App\Models\TsRollBanner;
use App\Repositories\AbstractBaseRepository;

class RollBannerRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(TsRollBanner $model)
    {
        $this->model = $model;
    }

    /**
     * @param null $search
     * @param int $limit
     *
     * @return object
     */
    public function getListRollBanner($search = null, $limit): object
    {
        $query = $this->model->orderBy('id', 'DESC');

        $query->FilterTitle($search);
        $query->FilterDate($search);

        return $this->paginatePageCurrent($this->handleGetDetailRollBanner($query->get()->toArray()), $limit);
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function handleGetDetailRollBanner($data): array
    {
        $arr = [];
        foreach ($data as $value) {
            if (!empty($value['post_id'])) {
                $dataPost = $this->getDetailPost($value);
                $value['data_post'] = $dataPost;
            }
            $arr[] = $value;
        }
        return $arr;
    }

    public function getDetailPost($data)
    {
        switch ($data['type']) {
            case 'pick_up':
                return TsCampaign::whereId($data['post_id'])->first(['id', 'title', 'created_at'])->toArray();
                break;

            case 'space':
                $dataRentalSpace = RentalSpace::whereId($data['post_id'])->first(['id', 'created_at'])->toArray();
                $rentalSpaceEav = RentalSpaceEav::where('attribute', 'generalBasicSpaceNameJa')->where('namespace', $dataRentalSpace['id'])->first('value');
                return $data = [
                    'id' => $dataRentalSpace['id'] ?? null,
                    'title' => $rentalSpaceEav->value ?? null,
                    'created_at' => $dataRentalSpace['created_at'] ?? null,
                ];

                break;

            case 'link':
                return null;
                break;

            case 'blog':
                #pending
                return null;
                break;

            case 'news':
                return TsNews::whereId($data['post_id'])->whereStatus(TsNews::STATUS_ACTIVE)->first(['id', 'title', 'created_at'])->toArray();
                break;
        }
    }


    /**
     * @param int $id
     * @return array
     */
    public function getDetailRollBanner(int $id): array
    {
        $query = $this->model->whereId($id)->first();
        $data = $query->toArray();
        if (!empty($data['post_id'])) {
            $data['data_post'] = $this->getDetailPost($data);
        }
        return $data;
    }
}
