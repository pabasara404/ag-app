<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TimberCuttingPermitApplicationBuilder
{
    static function whereStatus(string $status) : Builder|Model
    {
        return TimberCuttingPermitApplication::query()->where('status', $status);
    }
}
