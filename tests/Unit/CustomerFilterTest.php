<?php

use App\Filters\V1\CustomerFilter;
use Illuminate\Http\Request;

it('transforms equals queries', function () {
    $query = [
        'id' => '1',
        'name' => 'Kushal',
        'type' => 'I',
        'email' => 'kushal@example.com',
        'address' => 'Street no Something',
        'city' => 'Kolkata',
        'state' => 'West Bengal',
        'postalCode' => '123456',
    ];
    $request = Request::create('api/v1/customers', 'GET', $query);

    $customerFilter = new CustomerFilter;

    $elqQuery = [
        ['id', '=', '1'],
        ['name', '=', 'Kushal'],
        ['type', '=', 'I'],
        ['email', '=', 'kushal@example.com'],
        ['address', '=', 'Street no Something'],
        ['city', '=', 'Kolkata'],
        ['state', '=', 'West Bengal'],
        ['postal_code', '=', '123456']
    ];
    expect($customerFilter->transform($request))->toBe($elqQuery);
});
it('transforms Not Equals quaries', function () {
    $query = [
        'id' => ['nte' => '1'],
        'name' => ['nte' => 'Kushal'],
        'type' => ['nte' => 'I'],
        'email' => ['nte' => 'kushal@example.com'],
        'address' => ['nte' => 'Street no Something'],
        'city' => ['nte' => 'Kolkata'],
        'state' => ['nte' => 'West Bengal'],
        'postalCode' => ['nte' => '123456'],
    ];
    $request = new Request(query: $query);

    $customerFilter = new CustomerFilter;

    $elqQuery = [
        ['id', '<>', '1'],
        ['name', '<>', 'Kushal'],
        ['type', '<>', 'I'],
        ['email', '<>', 'kushal@example.com'],
        ['address', '<>', 'Street no Something'],
        ['city', '<>', 'Kolkata'],
        ['state', '<>', 'West Bengal'],
        ['postal_code', '<>', '123456']
    ];
    expect($customerFilter->transform($request))->toBe($elqQuery);
});
