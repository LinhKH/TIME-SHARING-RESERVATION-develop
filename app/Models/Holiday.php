<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Holiday extends Eloquent
{
    use HasFactory;

    protected $table = 'holiday';

    protected $fillable = [
        'id',
        'name',
        'year',
        'month',
        'day',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
