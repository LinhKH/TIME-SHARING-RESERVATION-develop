<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tour';

    protected $fillable = [
        'id',
        '4th_choice_date',
        '4th_choice_time',
        'checklist',
        'entry_time',
        'first_choice_date',
        'first_choice_time',
        'fix_choice_date_column_name',
        'fix_choice_time_column_name',
        'no_reason',
        'organization_id',
        'rental_space_id',
        'second_choice_date',
        'second_choice_time',
        'status',
        'substitute_first_choice_date',
        'substitute_first_choice_time',
        'substitute_second_choice_date',
        'substitute_second_choice_time',
        'substitute_third_choice_date',
        'substitute_third_choice_time',
        'third_choice_date',
        'third_choice_time',
        'use_plans_date',
        'use_plans_people',
        'use_purpose',
        'use_purpose_detail',
        'user_id',
        'user_view_flg'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    const CREATED_AT = 'entry_time';

    /**
     * Relation to Rental Space
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id')->with('rentalSpaceEav');
    }

    /**
     * Get the rental_space_eav .
     */
    public function rentalSpaceEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEav::class, 'namespace');
    }
}
