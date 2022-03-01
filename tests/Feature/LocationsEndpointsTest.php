<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocationsEndpointsTest extends TestCase
{
    public function testGetAllLocations()
    {
        $this->get('/api/v1/locations')
        ->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data"
        ]);
    }

    public function testGetSingleLocation()
    {
        $this->get('/api/v1/locations/1')
        ->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data"
        ]);
    }
}
