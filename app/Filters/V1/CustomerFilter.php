<?php

namespace App\Filters\V1;

use App\Filters\QueryFilter;

class CustomerFilter extends QueryFilter
{
    protected array $allowedColumns = [
        'id',
        'name',
        'type',
        'email',
        'address',
        'city',
        'state',
        'postalCode' => ['gt', 'lt', 'gte', 'lte'],
    ];

    protected array $columnMap = [
        'postalCode' => 'postal_code',
    ];
}
