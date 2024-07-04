<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvExport extends Model
{
    use HasFactory;

    const TARGETS = [
        'spaces',
        'customers',
        'contact-form',
        'catering-inquiry-form',
        'users',
        'organizations',
        'inquiries',
        'yakatabune-inquiry',
        'space-search-form',
        'reservations',
        'rental-space-reviews'
    ];
    protected $table = 'csv_export';
    protected $fillable = [
        'id',
        'target',
        'field',
        'item_order',
        'permission',
        'shown',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
