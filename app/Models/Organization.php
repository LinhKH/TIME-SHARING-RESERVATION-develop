<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organization';
    protected $fillable = [
        'id',
        'note',
        'locale_key',
        'active',
        'type',
        'creation_time',
        'parent_organization_id',
        'company_information',
        'postal_code',
        'url',
        'address',
        'latitude',
        'longitude',
        'phone_number',
        'fax_number',
        'access_information',
        'area_id',
        'payout_bank_account_id',
        'login_count_previous_month',
        'prefecture',
        'municipality',
        'completed_registration',
        'handling_fee_percentage',
        'tied_up',
        'tie_up_name',
        'tie_up_menu_title',
        'tie_up_menu',
        'tie_up_area_id',
        'tie_up_email',
        'proceeded_space_search_form_mail',
        'created_at',
        'updated_at'
    ];


    /**
     * Get the rental_space_eav .
     */
    public function rentalSpace(): HasMany
    {
        return $this->hasMany(RentalSpace::class, 'organization_id');
    }

    /**
     * Get bank account
     */
    public function organizationBankAccount(): HasMany
    {
        return $this->hasMany(OrganizationBankAccount::class, 'organization_id');
    }
}
