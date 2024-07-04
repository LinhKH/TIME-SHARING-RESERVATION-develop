<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inquiry extends Eloquent
{
    use HasFactory;

    protected $table = 'inquiry';

    protected $fillable = [
        'id',
        'customer_access_token',
        'tour_id',
        'user_id',
        'inquiry_typeWF',
        'created_by',
        'customer_id',
        'organization_id',
        'rental_space_id',
        'reservation_id',
        'title',
        'description',
        'creation_time',
        'from_ads_section',
        'support_done',
        'support_status',
        'person_in_charge',
        'internal_notes',
        'reminded_time',
        'is_read',
        'space_search_form_id',
        'offer_rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the tours
     */
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'id', 'tour_id');
    }

    /**
     * Get the users
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the customer
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    /**
     * Get the organizations
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'id', 'organization_id');
    }

    /**
     * Get the rentalSpaces
     */
    public function rentalSpaces(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');
    }

    /**
     * Get the rental_space_eav .
     */
    public function rentalSpaceEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEav::class, 'namespace');
    }

    /**
     * Get the reservations
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'id', 'reservation_id');
    }

    /**
     * Relation to Inquiry Reply
     */
    public function inquiryReply(): HasMany
    {
        return $this->hasMany(InquiryReply::class, 'inquiry_id', 'id');
    }
}
