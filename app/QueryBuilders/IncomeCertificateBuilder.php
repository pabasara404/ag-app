<?php

namespace App\QueryBuilders;

use App\Models\Citizen;
use App\Models\Employee;
use App\Models\IncomeCertificate;
use App\Models\IndividualBusiness;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IncomeCertificateBuilder
{
    public static function whereStatus(array $statuses): Builder
    {
        return IncomeCertificate::query()->whereIn('status', $statuses);
    }
}
