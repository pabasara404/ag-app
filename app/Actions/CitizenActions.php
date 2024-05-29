<?php

namespace App\Actions;

use App\Models\Citizen;
use App\Models\Employee;
use App\QueryBuilders\CitizenBuilder;
use App\QueryBuilders\EmployeeBuilder;
use Illuminate\Support\Collection;

class CitizenActions
{
    public static function all(): Collection
    {
        return Citizen::query()->all();
    }

    public static function getCitizenByUserId($userId): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return CitizenBuilder::whereUserId($userId);
    }

//    public static function update(array $employee): bool
//    {
//        return EmployeeBuilder::whereId($employee['id'])
//            ->update([
//                'name' => $employee['name'],
//                'address' => $employee['address'],
//                'contact_number' => $employee['contact_number'],
//                'date_of_birth' => $employee['date_of_birth'],
//            ]);
//    }




}
