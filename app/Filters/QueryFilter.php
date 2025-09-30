<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Exception;

class QueryFilter
{
    /*
     * By default 'equal to' and 'not equal to' is granted to all columns,
     * other operators must be explicitly specified safeOperation property.
     */

    protected array $allowedColumns = [];

    public array $columnMap = [];

    protected array $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'nte' => '<>',
        'like' => 'like',
    ];

    protected $ignoreParams = [];

    public function transform(Request $request): array
    {
        $query = $request->query();
        $elqQuery = [];
        foreach ($query as $column => $compArr) {
            // Skip Pagination
            if ($column == 'page' || in_array($column, $this->ignoreParams)) {
                continue;
            }
            // Check if column is allowed
            if (! array_key_exists($column, $this->allowedColumns) && ! in_array($column, $this->allowedColumns)) {
                throw new Exception("Column [ {$column} ] is not allowed");
            }
            // Check if any mapping is specifed for the column
            $elqColumn = $this->columnMap[$column] ?? $column;

            // If query is passed as column=value then by default equal operator is selected
            if (is_array($compArr)) {
                foreach ($compArr as $operator => $value) {
                    // Check for valid operator
                    $elqOperator = $this->operatorMap[$operator] ?? null;
                    if ($elqOperator === null) {
                        throw new Exception("[ {$operator} ] is not a valid Operator");
                    }
                    // Check if the column has operator specified in safeOperations
                    if ($elqOperator === '<>' || in_array($operator, $this->allowedColumns[$column] ?? [])) {
                        $elqArr = [$elqColumn, $elqOperator, $value];
                    } else {
                        throw new Exception("Operation [ {$operator} ] is not permitted on column [ {$column} ]");
                    }
                }
            } else {
                $elqArr = [$elqColumn, '=', $compArr];
            }
            $elqQuery[] = $elqArr ?? [];
        }

        return $elqQuery;
    }
}
