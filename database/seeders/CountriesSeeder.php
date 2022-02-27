<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    public $seedData = [
        ['name' => 'Nigeria', 'code' => 'NG'],
        ['name' => 'Kenya', 'code' => 'KE'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries_of_domicile')->insert($this->seedData);
    }
}
