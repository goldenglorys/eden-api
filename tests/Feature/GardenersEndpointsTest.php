<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Gardeners;
use Tests\TestCase;

class GardenersEndpointsTest extends TestCase
{
    use DatabaseTransactions;

    protected $gardener;

    protected $registerGardener;

    protected $invalidGardenerDetails;

    public function setUp(): void
    {
        parent::setUp();


        $this->invalidGardenerDetails = [
            'full_name' => 'Testing Full Name',
            'email' => 'test.gardener@mail.com',
            'location_area' => 'LA',
        ];

        $this->registerGardener = Gardeners::create([
            'full_name' => 'Testing Gardener',
            'email' => 'test.gardener1@mail.com',
            'location_area' => 1,
            'country_of_domicile' => 1,
        ]);

        $this->gardener = [
            'full_name' => 'Testing Full Name',
            'email' => 'test.gardener2@mail.com',
            'location_area' => 'LA',
            'country_of_domicile' => 'NG',
        ];
    }

    public function testGetAllGardeners()
    {
        $this->get('/api/v1/gardeners')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testGetSingleGardener()
    {
        $this->get('/api/v1/gardeners/1')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testCanCreateGardener()
    {
        $response = $this->json(
            'POST',
            'api/v1/gardeners',
            $this->gardener,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(201)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testCreateGardenerValidationError()
    {
        $response = $this->json(
            'POST',
            'api/v1/gardeners',
            $this->invalidGardenerDetails,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(422)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response2 = $this->json(
            'POST',
            'api/v1/gardeners',
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.gardener@mail.com',
                'location_area' => 'LAN',
                'country_of_domicile' => 'NG',
            ],
            ['Accept' => 'application/json']
        );
        $response2->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response3 = $this->json(
            'POST',
            'api/v1/gardeners',
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.gardener@mail.com',
                'location_area' => 'LA',
                'country_of_domicile' => 'SA',
            ],
            ['Accept' => 'application/json']
        );
        $response3->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "error"
            ]);
    }

    public function testCanUpdateGardener()
    {
        $response = $this->json(
            'PUT',
            'api/v1/gardeners/' . $this->registerGardener->id,
            $this->gardener,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(202)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testUpdategardenerValidationError()
    {
        $response = $this->json(
            'PUT',
            'api/v1/gardeners/' . $this->registerGardener->id,
            $this->invalidGardenerDetails,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(422)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response2 = $this->json(
            'PUT',
            'api/v1/gardeners/' . $this->registerGardener->id,
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.gardener@mail.com',
                'location_area' => 'LAN',
                'country_of_domicile' => 'NG',
            ],
            ['Accept' => 'application/json']
        );
        $response2->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response3 = $this->json(
            'PUT',
            'api/v1/gardeners/' . $this->registerGardener->id,
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.gardener@mail.com',
                'location_area' => 'LA',
                'country_of_domicile' => 'SA',
            ],
            ['Accept' => 'application/json']
        );
        $response3->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "error"
            ]);
    }

    public function testCanDeleteGardener()
    {
        $response = $this->json(
            'DELETE',
            'api/v1/gardeners/' . $this->registerGardener->id,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(204);
    }
}
