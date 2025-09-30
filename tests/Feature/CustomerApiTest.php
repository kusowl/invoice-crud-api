<?php

use App\Models\Customer;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

it('returns all Customer data', function () {
    $customers = Customer::factory()->count(3)->create();
    $response = $this->getJson('api/v1/customers');
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('data', 3, fn (AssertableJson $json) => $json
                ->hasAll(['id', 'name', 'type', 'email', 'address', 'city', 'state', 'postalCode']))
            ->has('links')
            ->has('meta'));
});

it('returns specifed Customer data', function () {
    $customer = Customer::factory()->count(3)->create()->first();

    $response = $this->getJson('api/v1/customers/'.$customer->id);

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json2) => $json2
                ->where('id', $customer->id)
                ->etc())
            ->etc()
    );
});

it('returns 404 incase of non exist id', function () {
    $response = $this->getJson('api/v1/customers/1');

    $response->assertStatus(404);
    $response->assertHeader('Content-Type', 'application/json');
});
// ------> Data with filter
// address =
it('does not return same data incase of not equal of specified email', function () {
    $customer = Customer::factory()->count(3)->create()->first();

    $response = $this->getJson('api/v1/customers?email[nte]='.$customer->email);

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data.0', fn (AssertableJson $json2) => $json2
                ->whereNot('id', $customer->id)
                ->etc())
            ->etc()
    );
});
// email !=
// postal code with all filter
