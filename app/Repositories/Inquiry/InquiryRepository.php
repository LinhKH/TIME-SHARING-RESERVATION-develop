<?php

namespace App\Repositories\Inquiry;

use App\Models\Inquiry;
use App\Models\RentalSpaceEav;
use App\Repositories\AbstractBaseRepository;

class InquiryRepository extends AbstractBaseRepository implements InquiryInterface
{
    public function __construct(Inquiry $model)
    {
        parent::__construct($model);
    }

    /**
     * @param null $search
     * @param  $auth
     * @return array
     */
    public function getListInquiryByProduct($search = null, $auth): array
    {
        if ($auth->getTable() === 'users') {
            $query = $this->model->newQuery();
        } else {
            $query = $this->model->where('customer_id', $auth->id);
        }

        $query->with(['customer' => function ($query) {
            $query->select('id', 'nickname', 'first_name', 'last_name', 'first_name_kana', 'last_name_kana', 'company_name');
        }]);

        $query->with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'first_name_furigana', 'last_name_furigana');
        }]);

        $query->with(['tours' => function ($query) {
            $query->select('*');
        }]);

        if (!empty($search['typeSort']) && !empty($search['sortBy'])) {
            $query->orderBy($search['sortBy'], $search['typeSort']);
        }

        return $this->addNameSpace($query->get()->toArray());
    }

    /**
     * @param $data
     * @param null $status
     * @return array
     */
    public function addNameSpace($data, $status = null): array
    {
        $arr = [];
        if (!empty($status)) {
            $query = RentalSpaceEav::where('namespace', $data['rental_space_id'])->where('attribute', 'generalBasicSpaceNameJa')->first();
            $data['namespace'] = $query['value'];

            return $data;
        } else {
            foreach ($data as $value) {
                if (!empty($value['rental_space_id'])) {
                    $query = RentalSpaceEav::where('namespace', $value['rental_space_id'])->where('attribute', 'generalBasicSpaceNameJa')->first();
                    $value['namespace'] = $query['value']??'';
                }

                array_push($arr, $value);
            }
        }


        return $arr;
    }

    /**
     * @param int $id
     * @param $auth
     * @return array
     */
    public function getDetailInquiry(int $id, $auth): array
    {
        $query = $this->model->whereId($id);

        if ($auth->getTable() !== 'users') {
            $query->where('customer_id', $auth->id);

            if (empty($query->first())) {
                return [];
            }
        }

        $query->with('reservations');

        $query->with(['customer' => function ($query) {
            $query->select('id', 'nickname', 'first_name', 'last_name', 'first_name_kana', 'last_name_kana', 'company_name', 'gender', 'phone_number', 'address', 'birthday_day_ident', 'email', 'business_structure', 'created_at');
        }]);

        $query->with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'first_name_furigana', 'last_name_furigana');
        }]);

        $query->with(['rentalSpaces' => function ($query) {
            $query->select('id',);
        }]);

        $query->with(['tours' => function ($query) {
            $query->select('*');
        }]);

        $data = $query->first()->toArray();
        if (empty($data['rental_space_id'])) {
            return  $data;
        }

        return $this->addNameSpace($data, $status = true);
    }
}
