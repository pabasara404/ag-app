<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\Valuation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ValuationBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return Valuation::query()->whereIn('status', $statuses);
    }

}
