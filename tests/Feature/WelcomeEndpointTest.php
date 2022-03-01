<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomeEndpointTest extends TestCase
{
    public function testWelcomeEnpoint()
    {
        $this->get('/api/v1/')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "message"
            ]);
    }
}
