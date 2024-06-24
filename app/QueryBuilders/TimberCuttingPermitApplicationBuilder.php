<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TimberCuttingPermitApplicationBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return TimberCuttingPermitApplication::query()->whereIn('status', $statuses);
    }
}
