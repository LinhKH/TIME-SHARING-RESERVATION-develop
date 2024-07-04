<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationBankAccount extends Model
{
    use HasFactory;
    protected $table = 'organization_bank_account';
    protected $fillable = [
        'id',
        'account_number',
        'bank_code',
        'bank_name',
        'bank_name_katakana',
        'branch_code',
        'branch_name',
        'branch_name_katakana',
        'holder_name_katakana',
        'creation_time',
        'type',
        'organization_id'
    ];

    public $timestamps = true;

    /**
     * Relation to Organization
     */
    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
