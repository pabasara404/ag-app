<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\Mahapola;
use App\Models\Valuation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MahapolaBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return Mahapola::query()->whereIn('status', $statuses);
    }

}
