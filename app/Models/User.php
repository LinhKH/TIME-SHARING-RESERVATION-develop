<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public const USER_STATUS_ACTIVE = 1;
    public const USER_STATUS_DEACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'creation_time',
        'email',
        'email_verified_at',
        'first_name',
        'last_name',
        'first_name_furigana',
        'last_name_furigana',
        'gender',
        'last_login_time',
        'locale_key',
        'locale_keys_spoken',
        'login_count_current_month',
        'login_trigger',
        'receive_space_search_form_notification',
        'subscribe_mail_magazine',
        'organization_id',
        'recovery_token',
        'roles',
        'working_groups',
        'type',
        'email',
        'password',
        'organization_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * Relation to Reservation
     */
    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }
}
