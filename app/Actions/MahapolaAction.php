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

    public static function getApplicationByStatus(string $statuses): Collection
    {
        $statusArray = array_filter(explode(',', $statuses)); // Filter out any empty values

        // Ensure $statusArray is not empty before querying
        if (empty($statusArray)) {
            return collect(); // Return an empty collection if no valid statuses are provided
        }

        return Mahapola::whereIn('status', $statusArray)
            ->with('gn_division')
            ->get();
    }


    public static function store(array $mahapola, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new MahapolaDTO($mahapola);
            $mahapola = Mahapola::create($dto);

            if (!empty($dto['user'])) {
                $user = User::find($dto['user']['id']);
                if ($user) {
                    $mahapola->user()->associate($user);
                    $mahapola->save();
                }
            }

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $mahapola->gn_division()->associate($gnDivision);
            $mahapola->save();

            DB::commit();

            return $mahapola;
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
