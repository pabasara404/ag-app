<?php
namespace App\Actions;

use App\DTO\MahapolaDTO;
use App\DTO\PresidentFundDTO;
use App\Models\Mahapola;
use App\Models\PresidentFund;
use App\Models\GNDivision;
use App\Models\User;
use App\QueryBuilders\MahapolaBuilder;
use App\QueryBuilders\PresidentFundBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MahapolaAction
{
    public static function all(): Collection
    {
        return Mahapola::all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return MahapolaBuilder::whereStatus($statusArray)
        ->with('gn_division')
        ->get();
    }

    public static function store(array $mahapola, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new MahapolaDTO($mahapola);
            $mahapola = Mahapola::create($dto);

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $mahapola->gn_division()->associate($gnDivision);
            $mahapola->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
