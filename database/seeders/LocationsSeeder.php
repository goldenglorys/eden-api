<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public $seedData = [
        ['name' => 'Abuja', 'code' => 'FC', 'country_code' => 'NG'],
        ['name' => 'Abia', 'code' => 'AB', 'country_code' => 'NG'],
        ['name' => 'Adamawa', 'code' => 'AD', 'country_code' => 'NG'],
        ['name' => 'AkwaIbom', 'code' => 'AK', 'country_code' => 'NG'],
        ['name' => 'Anambra', 'code' => 'AN', 'country_code' => 'NG'],
        ['name' => 'Bauchi', 'code' => 'BA', 'country_code' => 'NG'],
        ['name' => 'Bayelsa', 'code' => 'BY', 'country_code' => 'NG'],
        ['name' => 'Benue', 'code' => 'BE', 'country_code' => 'NG'],
        ['name' => 'Borno', 'code' => 'BO', 'country_code' => 'NG'],
        ['name' => 'CrossRiver', 'code' => 'CR', 'country_code' => 'NG'],
        ['name' => 'Delta', 'code' => 'DE', 'country_code' => 'NG'],
        ['name' => 'Ebonyi', 'code' => 'EB', 'country_code' => 'NG'],
        ['name' => 'Edo', 'code' => 'ED', 'country_code' => 'NG'],
        ['name' => 'Ekiti', 'code' => 'EK', 'country_code' => 'NG'],
        ['name' => 'Enugu', 'code' => 'EN', 'country_code' => 'NG'],
        ['name' => 'Gombe', 'code' => 'GO', 'country_code' => 'NG'],
        ['name' => 'Imo', 'code' => 'IM', 'country_code' => 'NG'],
        ['name' => 'Jigawa', 'code' => 'JI', 'country_code' => 'NG'],
        ['name' => 'Kaduna', 'code' => 'KD', 'country_code' => 'NG'],
        ['name' => 'Kano', 'code' => 'KN', 'country_code' => 'NG'],
        ['name' => 'Katsina', 'code' => 'KT', 'country_code' => 'NG'],
        ['name' => 'Kebbi', 'code' => 'KE', 'country_code' => 'NG'],
        ['name' => 'Kogi', 'code' => 'KO', 'country_code' => 'NG'],
        ['name' => 'Kwara', 'code' => 'KW', 'country_code' => 'NG'],
        ['name' => 'Lagos', 'code' => 'LA', 'country_code' => 'NG'],
        ['name' => 'Nassarawa', 'code' => 'NA', 'country_code' => 'NG'],
        ['name' => 'Niger', 'code' => 'NI', 'country_code' => 'NG'],
        ['name' => 'Ogun', 'code' => 'OG', 'country_code' => 'NG'],
        ['name' => 'Ondo', 'code' => 'ON', 'country_code' => 'NG'],
        ['name' => 'Osun', 'code' => 'OS', 'country_code' => 'NG'],
        ['name' => 'Oyo', 'code' => 'OY', 'country_code' => 'NG'],
        ['name' => 'Plateau', 'code' => 'PL', 'country_code' => 'NG'],
        ['name' => 'Rivers', 'code' => 'RI', 'country_code' => 'NG'],
        ['name' => 'Sokoto', 'code' => 'SO', 'country_code' => 'NG'],
        ['name' => 'Taraba', 'code' => 'TA', 'country_code' => 'NG'],
        ['name' => 'Yobe', 'code' => 'YO', 'country_code' => 'NG'],
        ['name' => 'Zamfara', 'code' => 'ZA', 'country_code' => 'NG'],

        
        ['name' => 'Central Kenya', 'code' => 'CE', 'country_code' => 'KE'],
        ['name' => 'Coastal Kenya', 'code' => 'CO', 'country_code' => 'KE'],
        ['name' => 'East Kenya', 'code' => 'EA', 'country_code' => 'KE'],
        ['name' => 'Nairobi', 'code' => 'NA', 'country_code' => 'KE'],
        ['name' => 'Northeast Kenya', 'code' => 'NO', 'country_code' => 'KE'],
        ['name' => 'Nyanza', 'code' => 'NY', 'country_code' => 'KE'],
        ['name' => 'Rift Valley', 'code' => 'RI', 'country_code' => 'KE'],
        ['name' => 'West Kenya', 'code' => 'WE', 'country_code' => 'KE'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location_areas')->insert($this->seedData);
    }
}
