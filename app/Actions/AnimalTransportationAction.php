<?php

namespace App\Actions;

use App\DTO\AnimalTransportationDTO;
use App\DTO\IndividualBusinessDTO;
use App\Models\Address;
use App\Models\Animal;
use App\Models\AnimalTransportation;
use App\Models\IndividualBusiness;
use App\Models\OwnerDetail;
use App\Models\OtherBusiness;
use App\Models\DirectorDetail;
use App\Models\User;
use App\QueryBuilders\AnimalTransportationBuilder;
use App\QueryBuilders\IndividualBusinessBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnimalTransportationAction
{
    public static function all(): Collection
    {
        return IndividualBusiness::query()->all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return AnimalTransportationBuilder::whereStatus($statusArray)
            ->with([
                'animals'
            ])
            ->get();
    }

    static function store(array $animalTransportation)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new AnimalTransportationDTO($animalTransportation);
            $dto['application_code'] = AnimalTransportation::generateApplicationCode();
            $animalTransportation = AnimalTransportation::create($dto);

            collect($dto['animals'])->each(function ($animal) use ($animalTransportation) {
                $animal['animal_transportation_id'] = $animalTransportation->id;
                $animal = Animal::create($animal);
                $animalTransportation->animals()->save($animal);
            });

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

}
