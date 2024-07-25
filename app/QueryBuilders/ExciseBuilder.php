<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\Excise;
use App\Models\Valuation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ExciseBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return Excise::query()->whereIn('status', $statuses);
    }

}
