<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceEmailMessage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_email_message';
    protected $fillable = [
        'id',
        'creation_time',
        'rental_space_id',
        'type',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * RelationShip rental_space
     *
     * @return BelongsTo
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');

    }

    /**
     * Get the rental_space_email_message_eav .
     */
    public function rentalSpaceEmailMessageEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEmailMessageEav::class, 'namespace');
    }
}
