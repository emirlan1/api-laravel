<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use illuminate\Http\Request;

class UserFilter extends ApiFilter{
    protected $safeParams = [
        'id' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'email' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'createdAt' => 'created_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}
