<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\PresidentFund;
use App\Models\Valuation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PresidentFundBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return PresidentFund::query()->whereIn('status', $statuses);
    }

}
