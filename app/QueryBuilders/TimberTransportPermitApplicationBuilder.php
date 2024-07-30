<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TimberTransportingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TimberTransportPermitApplicationBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return TimberTransportingPermitApplication::query()->whereIn('status', $statuses);
    }
}
