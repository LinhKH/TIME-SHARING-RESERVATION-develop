<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationOptionTypeReservationOptionTypeEav extends Model
{
    use HasFactory;

    protected $table = 'reservation_option_type_reservation_option_type_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Relation to Reservation Option Type Reservation Option Type Eav
     */
    public function reservationOptionType(): BelongsTo
    {
        return $this->belongsTo(ReservationOptionTypeReservationOptionType::class, 'namespace');
    }
}
