<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public $seedData = [
        ['id' => 1, 'name' => 'Abuja', 'code' => 'FC', 'country' => 1],
        ['id' => 2, 'name' => 'Abia', 'code' => 'AB', 'country' => 1],
        ['id' => 3, 'name' => 'Adamawa', 'code' => 'AD', 'country' => 1],
        ['id' => 4, 'name' => 'AkwaIbom', 'code' => 'AK', 'country' => 1],
        ['id' => 5, 'name' => 'Anambra', 'code' => 'AN', 'country' => 1],
        ['id' => 6, 'name' => 'Bauchi', 'code' => 'BA', 'country' => 1],
        ['id' => 7, 'name' => 'Bayelsa', 'code' => 'BY', 'country' => 1],
        ['id' => 8, 'name' => 'Benue', 'code' => 'BE', 'country' => 1],
        ['id' => 9, 'name' => 'Borno', 'code' => 'BO', 'country' => 1],
        ['id' => 10, 'name' => 'CrossRiver', 'code' => 'CR', 'country' => 1],
        ['id' => 11, 'name' => 'Delta', 'code' => 'DE', 'country' => 1],
        ['id' => 12, 'name' => 'Ebonyi', 'code' => 'EB', 'country' => 1],
        ['id' => 13, 'name' => 'Edo', 'code' => 'ED', 'country' => 1],
        ['id' => 14, 'name' => 'Ekiti', 'code' => 'EK', 'country' => 1],
        ['id' => 15, 'name' => 'Enugu', 'code' => 'EN', 'country' => 1],
        ['id' => 16, 'name' => 'Gombe', 'code' => 'GO', 'country' => 1],
        ['id' => 17, 'name' => 'Imo', 'code' => 'IM', 'country' => 1],
        ['id' => 18, 'name' => 'Jigawa', 'code' => 'JI', 'country' => 1],
        ['id' => 19, 'name' => 'Kaduna', 'code' => 'KD', 'country' => 1],
        ['id' => 20, 'name' => 'Kano', 'code' => 'KN', 'country' => 1],
        ['id' => 21, 'name' => 'Katsina', 'code' => 'KT', 'country' => 1],
        ['id' => 22, 'name' => 'Kebbi', 'code' => 'KE', 'country' => 1],
        ['id' => 23, 'name' => 'Kogi', 'code' => 'KO', 'country' => 1],
        ['id' => 24, 'name' => 'Kwara', 'code' => 'KW', 'country' => 1],
        ['id' => 25, 'name' => 'Lagos', 'code' => 'LA', 'country' => 1],
        ['id' => 26, 'name' => 'Nassarawa', 'code' => 'NA', 'country' => 1],
        ['id' => 27, 'name' => 'Niger', 'code' => 'NI', 'country' => 1],
        ['id' => 28, 'name' => 'Ogun', 'code' => 'OG', 'country' => 1],
        ['id' => 29, 'name' => 'Ondo', 'code' => 'ON', 'country' => 1],
        ['id' => 30, 'name' => 'Osun', 'code' => 'OS', 'country' => 1],
        ['id' => 31, 'name' => 'Oyo', 'code' => 'OY', 'country' => 1],
        ['id' => 32, 'name' => 'Plateau', 'code' => 'PL', 'country' => 1],
        ['id' => 33, 'name' => 'Rivers', 'code' => 'RI', 'country' => 1],
        ['id' => 34, 'name' => 'Sokoto', 'code' => 'SO', 'country' => 1],
        ['id' => 35, 'name' => 'Taraba', 'code' => 'TA', 'country' => 1],
        ['id' => 36, 'name' => 'Yobe', 'code' => 'YO', 'country' => 1],
        ['id' => 37, 'name' => 'Zamfara', 'code' => 'ZA', 'country' => 1],

        ['id' => 38, 'name' => 'Central Kenya', 'code' => 'CE', 'country' => 2],
        ['id' => 39, 'name' => 'Coastal Kenya', 'code' => 'CO', 'country' => 2],
        ['id' => 40, 'name' => 'East Kenya', 'code' => 'EA', 'country' => 2],
        ['id' => 41, 'name' => 'Nairobi', 'code' => 'NA', 'country' => 2],
        ['id' => 42, 'name' => 'Northeast Kenya', 'code' => 'NO', 'country' => 2],
        ['id' => 43, 'name' => 'Nyanza', 'code' => 'NY', 'country' => 2],
        ['id' => 44, 'name' => 'Rift Valley', 'code' => 'RI', 'country' => 2],
        ['id' => 45, 'name' => 'West Kenya', 'code' => 'WE', 'country' => 2],
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
