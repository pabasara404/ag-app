<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CitizenBuilder
{
    static function whereUserId(int $id) : Builder|Model
    {
        return Citizen::query()->firstWhere('user_id', $id);
    }
}
