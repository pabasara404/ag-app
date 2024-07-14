<?php

namespace App\QueryBuilders;

use App\Models\AnimalTransportation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AnimalTransportationBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return AnimalTransportation::query()->whereIn('status', $statuses);
    }
}
