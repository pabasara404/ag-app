<?php

namespace App\Actions;

use App\DTO\ExciseDTO;
use App\DTO\IncomeCertificateDTO;
use App\Models\Excise;
use App\Models\IncomeCertificate;
use App\Models\Income;
use App\Models\SamurdhiDetail;
use App\Models\GNDivision;
use App\Models\User;
use App\QueryBuilders\ExciseBuilder;
use App\QueryBuilders\IncomeCertificateBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExciseAction
{
    public static function all(): Collection
    {
        return Excise::all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return ExciseBuilder::whereStatus($statusArray)
            ->with('gn_division')
            ->get();
    }

    public static function store(array $excise, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new ExciseDTO($excise);
            $dto['application_code'] = Excise::generateApplicationCode();
            $excise = Excise::create($dto);

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $excise->gn_division()->associate($gnDivision);
            $excise->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

}
