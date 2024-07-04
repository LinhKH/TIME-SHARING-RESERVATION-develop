<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrganizationsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SystemConfigsTableSeeder::class);
        $this->call(TransportationRouteSeeder::class);
        $this->call(TransportationRouteEavSeeder::class);
        $this->call(TransportationStationSeeder::class);
        $this->call(TransportationStationEavSeeder::class);
        $this->call(TransportationRouteStationSeeder::class);
        $this->call(TransportationStationSearchCoordinateSeeder::class);
        $this->call(TransportationStationSearchKeywordSeeder::class);
        $this->call(PostalCodePrefectureSeeder::class);
        $this->call(PostalCodeCitySeeder::class);
        $this->call(PostalCodeSeeder::class);
        $this->call(PostalCodePrefectureEavSeeder::class);
        $this->call(PostalCodeCityEavSeeder::class);
        $this->call(PostalCodeEavSeeder::class);
        $this->call(ConfigCsvSeeder::class);

    }
}
