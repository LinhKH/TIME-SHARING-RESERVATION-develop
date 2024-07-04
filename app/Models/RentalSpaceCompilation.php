<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceCompilation extends Model
{

    use HasFactory;

    protected $table = 'rental_space_compilation';
    protected $fillable = [
        'id',
        'access_key',
        'active',
        'creation_time',
        'modification_time',
        'order_number',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * Get the rental_space_compilation_eav .
     */
    public function rentalSpaceCompilationEav(): HasMany
    {
        return $this->hasMany(RentalSpaceCompilationEav::class, 'namespace');
    }

    /**
     * Get the rental_space_compilation_image .
     */
    public function rentalSpaceCompilationImage(): HasMany
    {
        return $this->hasMany(RentalSpaceCompilationImage::class, 'parent_id');
    }

}
