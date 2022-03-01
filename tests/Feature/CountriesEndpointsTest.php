<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountriesEndpointsTest extends TestCase
{
    public function testGetAllCountries()
    {
        $this->get('/api/v1/countries')
        ->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data"
        ]);
    }

    public function testGetSingleCountry()
    {
        $this->get('/api/v1/countries/1')
        ->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data"
        ]);
    }
}
