<?php

namespace App\Filters\V1;

use App\Filters\QueryFilter;

class InvoiceFilter extends QueryFilter
{
    protected array $allowedColumns = [
        'id',
        'customerId',
        'amount' => ['gt', 'lt', 'gte', 'lte'],
        'status',
        'billedDate' => ['gt', 'lt', 'gte', 'lte'],
        'paidDate' => ['gt', 'lt', 'gte', 'lte'],
    ];

    public array $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date',
    ];
}
