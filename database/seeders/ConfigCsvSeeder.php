<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql_space = file_get_contents('database/seeders/features/csv_export_target_spaces.sql');
        DB::statement($sql_space);

        $sql_yakatabune = file_get_contents('database/seeders/features/csv_export_yakatabune_inquiry.sql');
        DB::statement($sql_yakatabune);

        $sql_user = file_get_contents('database/seeders/features/csv_export_users.sql');
        DB::statement($sql_user);

        $sql_customer = file_get_contents('database/seeders/features/csv_export_target_customers.sql');
        DB::statement($sql_customer);

        $sql_space_search_form = file_get_contents('database/seeders/features/csv_export_space_search_form.sql');
        DB::statement($sql_space_search_form);

        $sql_reservations = file_get_contents('database/seeders/features/csv_export_reservations.sql');
        DB::statement($sql_reservations);

//        $sql_rental_space_reviews = file_get_contents('database/seeders/features/csv_export_rental_space_reviews.sql');
//        DB::statement($sql_rental_space_reviews);

        $sql_organizations = file_get_contents('database/seeders/features/csv_export_organizations.sql');
        DB::statement($sql_organizations);

        $sql_inquiries = file_get_contents('database/seeders/features/csv_export_inquiries.sql');
        DB::statement($sql_inquiries);

        $sql_contact_form = file_get_contents('database/seeders/features/csv_export_contact_form.sql');
        DB::statement($sql_contact_form);

        $sql_catering_inquiry_form = file_get_contents('database/seeders/features/csv_export_catering_inquiry_form.sql');
        DB::statement($sql_catering_inquiry_form);

    }
}
