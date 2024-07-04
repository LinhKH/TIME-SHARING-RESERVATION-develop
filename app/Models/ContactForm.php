<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $table = 'contact_form';
    protected $fillable = [
        'id',
        'creation_time',
        'name',
        'email',
        'message',
        'type',
        'name_furigana',
        'company_name',
        'department',
        'phone_number',
        'support_status',
        'person_in_charge',
        'internal_notes',
        'enquirer',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
