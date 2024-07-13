<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\IndividualBusiness;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IndividualBusinessBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return IndividualBusiness::query()->whereIn('status', $statuses);
    }
}
