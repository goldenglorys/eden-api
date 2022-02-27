<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LocationAreas;
use App\Models\CountriesOfDomicile;
use Illuminate\Support\Facades\DB;


class GardenersSeeder extends Seeder
{    
    public $seedData = [
        ['full_name' => 'Alpha Lagos Gardener', 'email' => 'alphalagosgardener@eden.life', 'location_area' => 25, 'country_of_domicile' => 1],
        ['full_name' => 'Beta Lagos Gardener', 'email' => 'betalagosgardener@eden.life', 'location_area' => 25, 'country_of_domicile' => 1],
        ['full_name' => 'Alpha Abuja Gardener', 'email' => 'alphaabujagardener@eden.life', 'location_area' => 1, 'country_of_domicile' => 1],

        ['full_name' => 'Alpha Nairobi Gardener', 'email' => 'alphanairobigardener@eden.life', 'location_area' => 41, 'country_of_domicile' => 2],
        ['full_name' => 'Beta Nairobi Gardener', 'email' => 'betanairobigardener@eden.life', 'location_area' => 41, 'country_of_domicile' => 2],
        ['full_name' => 'Alpha West Kenya Gardener', 'email' => 'alphawestkenyagardener@eden.life', 'location_area' => 45, 'country_of_domicile' => 2],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gardeners')->insert($this->seedData);
    }
}
