<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            [
                'id' => 1,
                'note' => '',
                'locale_key' => 'ja',
                'active' => 1,
                'type' => 'company',
                'creation_time' => 1582711818,
                'parent_organization_id' => null,
                'company_information' => '{
                "name": "TXT HTG 1001",
                "name_furigana": "カブシキガイシャアドバル"
            }',
                'postal_code' => '150-0042',
                'url' => null,
                'address' => '宇田川町33-7',
                'latitude' => 35.6608668,
                'longitude' => 140,
                'phone_number' => '05020183178',
                'fax_number' => '',
                'access_information' => '[]',
                'area_id' => null,
                'payout_bank_account_id' => 4,
                'login_count_previous_month' => 2,
                'prefecture' => '東京都',
                'municipality' => '渋谷区',
                'completed_registration' => 1,
                'handling_fee_percentage' => null,
                'tied_up' => 0,
                'tie_up_name' => '',
                'tie_up_menu_title' => '',
                'tie_up_menu' => '',
                'tie_up_area_id' => null,
                'tie_up_email' => '',
                'proceeded_space_search_form_mail' => 0,
                'created_at' => null,
                'updated_at' => null,
            ]
        ];
        foreach ($defaults as $v) {
            Organization::create($v);
        }
    }
}
