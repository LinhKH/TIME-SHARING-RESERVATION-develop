<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'email_template';
    protected $fillable = [
        'id',
        'email_type',
        'email_subject_en',
        'email_subject_jp',
        'content_en',
        'content_jp',
        'memo_en',
        'memo_jp'
    ];

    public $timestamps = true;

}
