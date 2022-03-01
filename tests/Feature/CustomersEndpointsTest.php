<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Customers;
use App\Models\Gardeners;
use Tests\TestCase;

class CustomersEndpointsTest extends TestCase
{
    use DatabaseTransactions;

    protected $customer;

    protected $registerCustomer;

    protected $registerGardener;

    protected $invalidCustomerDetails;

    public function setUp(): void
    {
        parent::setUp();


        $this->invalidCustomerDetails = [
            'full_name' => 'Testing Full Name',
            'email' => 'test.customer@mail.com',
            'location_area' => 'LA',
        ];

        $this->registerGardener = Gardeners::create([
            'full_name' => 'Testing Gardener',
            'email' => 'test.gardener@mail.com',
            'location_area' => 1,
            'country_of_domicile' => 1,
        ]);

        $this->registerCustomer = Customers::create([
            'full_name' => 'Testing Automation Full Name',
            'email' => 'testing.register.customer@mail.com',
            'location_area' => 1,
            'country_of_domicile' => 1,
            'gardener' => $this->registerGardener->id,
        ]);

        $this->customer = [
            'full_name' => 'Testing Full Name',
            'email' => 'test.customer@mail.com',
            'location_area' => 'LA',
            'country_of_domicile' => 'NG',
            'gardener' => $this->registerGardener->id,
        ];
    }

    public function testGetAllCustomers()
    {
        $this->get('/api/v1/customers')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testGetSingleCountry()
    {
        $this->get('/api/v1/customers/1')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testCanCreateCustomer()
    {
        $response = $this->json(
            'POST',
            'api/v1/customers',
            $this->customer,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(201)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testCreateCustomerValidationError()
    {
        $response = $this->json(
            'POST',
            'api/v1/customers',
            $this->invalidCustomerDetails,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(422)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response2 = $this->json(
            'POST',
            'api/v1/customers',
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.customer@mail.com',
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
            'api/v1/customers',
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.customer@mail.com',
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

    public function testCanUpdateCustomer()
    {
        $response = $this->json(
            'PUT',
            'api/v1/customers/' . $this->registerCustomer->id,
            $this->customer,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(202)
            ->assertJsonStructure([
                "success",
                "data"
            ]);
    }

    public function testUpdateCustomerValidationError()
    {
        $response = $this->json(
            'PUT',
            'api/v1/customers/' . $this->registerCustomer->id,
            $this->invalidCustomerDetails,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(422)
            ->assertJsonStructure([
                "success",
                "error"
            ]);

        $response2 = $this->json(
            'PUT',
            'api/v1/customers/' . $this->registerCustomer->id,
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.customer@mail.com',
                'location_area' => 'LAN',
                'country_of_domicile' => 'NG',
                'gardener' => $this->registerGardener->id,
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
            'api/v1/customers/' . $this->registerCustomer->id,
            [
                'full_name' => 'Testing Full Name',
                'email' => 'test.customer@mail.com',
                'location_area' => 'LA',
                'country_of_domicile' => 'SA',
                'gardener' => $this->registerGardener->id,
            ],
            ['Accept' => 'application/json']
        );
        $response3->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "error"
            ]);
    }

    public function testCanDeleteCustomer()
    {
        $response = $this->json(
            'DELETE',
            'api/v1/customers/' . $this->registerCustomer->id,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(204);
    }
}
