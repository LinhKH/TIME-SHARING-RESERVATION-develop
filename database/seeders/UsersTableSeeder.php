<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
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
                'active' => '1',
                'creation_time' => '1576770426',
                'email' => 'admin@s-management.co.jp',
                'first_name' => '管理者',
                'last_name' => 'カンリシャ',
                'first_name_furigana' => 'スペマネ',
                'last_name_furigana' => 'スペマネ',
                'password' => bcrypt('foDIaRtkhyOp^M3JVhuHX9(5'),
                'gender' => 'male',
                'type' => 'admin',
                'organization_id' => 1,
                'locale_key' => 'ja',
                'locale_keys_spoken' => '["ja"]',
                'last_login_time' => '1576770426',
                'login_count_current_month' => '1576770426',
                'login_trigger' => '1',
                'receive_space_search_form_notification' => '1',
                'subscribe_mail_magazine' => '1',
                'recovery_token' => 'foDIaRtkhyOp^M3JVhuHX9',
                'roles' => '["all"]',
                'working_groups' => '[]'
            ]
        ];
        foreach($defaults as $v){
            User::create($v);
        }
    }
}
