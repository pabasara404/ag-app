<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\Firm;
use App\Models\IndividualBusiness;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FirmBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return Firm::query()->whereIn('status', $statuses);
    }
}
