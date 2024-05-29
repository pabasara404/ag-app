<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;

class CitizenBuilder
{
    static function whereUserId(int $id) : \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return Citizen::query()->firstWhere('user_id', $id);
    }
}
