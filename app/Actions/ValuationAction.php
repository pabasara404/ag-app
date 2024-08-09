<?php

namespace App\Actions;

use App\DTO\IncomeCertificateDTO;
use App\DTO\ValuationDTO;
use App\Models\IncomeCertificate;
use App\Models\Income;
use App\Models\SamurdhiDetail;
use App\Models\GNDivision;
use App\Models\User;
use App\Models\Valuation;
use App\QueryBuilders\IncomeCertificateBuilder;
use App\QueryBuilders\ValuationBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ValuationAction
{
    public static function all(): Collection
    {
        return Valuation::all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return ValuationBuilder::whereStatus($statusArray)
            ->with('gn_division')
            ->get();
    }

    public static function store(array $valuation, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new ValuationDTO($valuation);
            $dto['application_code'] = Valuation::generateApplicationCode();
            $valuation = Valuation::create($dto);

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $valuation->gn_division()->associate($gnDivision);
            $valuation->save();

            if (!empty($dto['user'])) {
                $user = User::find($dto['user']['id']);
                if ($user) {
                    $valuation->user()->associate($user);
                    $valuation->save();
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }


}
