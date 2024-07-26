<?php
namespace App\Actions;

use App\DTO\PresidentFundDTO;
use App\Models\PresidentFund;
use App\Models\GNDivision;
use App\Models\User;
use App\QueryBuilders\PresidentFundBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PresidentFundAction
{
    public static function all(): Collection
    {
        return PresidentFund::all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return PresidentFundBuilder::whereStatus($statusArray)
        ->with('gn_division')
        ->get();
    }

    public static function store(array $presidentFund, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new PresidentFundDTO($presidentFund);
            $presidentFund = PresidentFund::create($dto);

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $presidentFund->gn_division()->associate($gnDivision);
            $presidentFund->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
