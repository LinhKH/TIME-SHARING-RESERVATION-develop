<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceEmailMessageEav extends Model
{

    use HasFactory;

    protected $table = 'rental_space_email_message_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip rentalSpaceEmailMessage
     *
     * @return BelongsTo
     */
    public function rentalSpaceEmailMessage(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceEmailMessage::class, 'namespace');

    }
}
