<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public const CUSTOMER_STATUS_ACTIVE = 1;
    public const CUSTOMER_STATUS_DEACTIVE = 0;
    public const CUSTOMER_STATUS_UNCONFIRM = 2;

    protected $table = 'customer';
    protected $fillable = [
        'id',
        'nickname',
        'facebook_user_id',
        'company_name',
        'company_name_kana',
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'email',
        'password',
        'phone_number',
        'address',
        'birthday_day_ident',
        'card_holder_first_name',
        'card_holder_last_name',
        'card_type',
        'card_reference',
        'card_date_of_expiry',
        'locale_key',
        'confirmation_token',
        'recovery_token',
        'creation_time',
        'active',
        'login_email',
        'type',
        'next_url',
        'receiving_reservation_emails',
        'newsletter_subscribed',
        'gender',
        'business_structure',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Get the rental_space_favorite .
     */
    public function rentalSpaceFavorite(): HasMany
    {
        return $this->hasMany(RentalSpaceFavorite::class, 'customer_id');
    }

    /**
     * Get the rental_space_review .
     */
    public function rentalSpaceReview(): HasMany
    {
        return $this->hasMany(RentalSpaceReview::class, 'customer_id', 'id');
    }

    /**
     * Get the reservation .
     */
    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class, 'customer_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterEmail($query, $request): object
    {
        if (isset($request['email'])) {
            $query->where('email', 'like', "%{$request['email']}%");
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterName($query, $request): object
    {
        if (isset($request['first_name'])) {
            $query->where('first_name', 'like', "%{$request['first_name']}%");
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterPhoneNumber($query, $request): object
    {
        if (isset($request['phone_number'])) {
            $query->where('phone_number', 'like', "%{$request['phone_number']}%");
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterAddress($query, $request): object
    {
        if (isset($request['address'])) {
            $query->where('address', 'like', "%{$request['address']}%");
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterEmailStatus($query, $request): object
    {
        if (isset($request['email_status'])) {
            if ($request['email_status'] == 'notNull') {
                $query->whereNotNull('email');
            } elseif ($request['email_status'] == 'null') {
                $query->whereNull('email');
            }
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterPhoneNumberStatus($query, $request): object
    {
        if (isset($request['phone_number_status'])) {
            if ($request['phone_number_status'] == 'notNull') {
                $query->whereNotNull('phone_number');
            } elseif ($request['phone_number_status'] == 'null') {
                $query->whereNull('phone_number');
            }
        }

        return $query;
    }

    /**
     * @param $query
     * @param $request
     *
     * @return object
     */
    public function scopeFilterRegistrationDate($query, $request): object
    {
        if (isset($request['registration_date'])) {
            if (!empty($request['registration_date']['from']) && !empty($request['registration_date']['to'])) {
                $query->whereBetween('created_at', [$request['registration_date']['from'], $request['registration_date']['to']]);
            }
        }

        return $query;
    }
}
