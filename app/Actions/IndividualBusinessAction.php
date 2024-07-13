<?php

namespace App\Actions;

use App\DTO\IndividualBusinessDTO;
use App\Models\Address;
use App\Models\IndividualBusiness;
use App\Models\OwnerDetail;
use App\Models\OtherBusiness;
use App\Models\DirectorDetail;
use App\Models\User;
use App\QueryBuilders\IndividualBusinessBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IndividualBusinessAction
{
    public static function all(): Collection
    {
        return IndividualBusiness::query()->all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return IndividualBusinessBuilder::whereStatus($statusArray)
            ->with([
                'addresses',
                'owner_detail',
                'other_businesses',
                'director_details'
            ])
            ->get();
    }

    public static function store(array $individualBusiness, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new IndividualBusinessDTO($individualBusiness);
            $dto['application_code'] = IndividualBusiness::generateApplicationCode();
            $individualBusiness = IndividualBusiness::create($dto);
            $ownerDetail = OwnerDetail::create($dto['owner_detail']);

            $individualBusiness->owner_detail_id = $ownerDetail->id;
            $individualBusiness->save();

            collect($dto['addresses'])->each(function ($address) use ($individualBusiness) {
                $addresses = Address::create($address);
                $individualBusiness->addresses()->save($addresses);
            });

            collect($dto['other_businesses'])->each(function ($otherBusiness) use ($individualBusiness) {
                $otherBusiness = OtherBusiness::create($otherBusiness);
                $individualBusiness->other_businesses()->save($otherBusiness);
            });

            collect($dto['director_details'])->each(function ($directorDetail) use ($individualBusiness) {
                $directorDetails = DirectorDetail::create($directorDetail);
                $individualBusiness->director_details()->save($directorDetails);
            });

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
