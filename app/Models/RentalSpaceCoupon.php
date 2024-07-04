<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceCoupon extends Model
{
    use HasFactory;

    protected $table = 'rental_space_coupon';
    protected $fillable = [
        'id',
        'code',
        'customer_ids',
        'days_of_the_week',
        'discount_percentage',
        'enabled',
        'mail_text',
        'master',
        'memo',
        'name',
        'number_of_people',
        'plan_ids',
        'space_ids',
        'usable_from',
        'usable_to',
        'usage_count',
        'valid_from',
        'valid_to',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * @param $query
     * @param $request
     * @return object
     */
    public function scopeFilterCode($query, $request): object
    {
        if (isset($request['code'])) {
            $query->where('code', $request['code']);
        }

        return $query;
    }
}
