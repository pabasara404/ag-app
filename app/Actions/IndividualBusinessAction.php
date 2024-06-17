<?php

namespace App\Actions;

use App\DTO\IndividualBusinessDTO;
use App\Models\Address;
use App\Models\Boundaries;
use App\Models\Citizen;
use App\Models\DeedDetail;
use App\Models\DirectorDetail;
use App\Models\OtherBusiness;
use App\Models\OwnerDetail;
use App\Models\LandDetail;
use App\Models\IndividualBusiness;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IndividualBusinessAction
{
    public static function all(): Collection
    {
        return IndividualBusiness::query()->all();
    }


    public static function store(array $individualBusiness, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new IndividualBusinessDTO($individualBusiness);
            $individualBusiness = IndividualBusiness::create($dto);
            $ownerDetail = OwnerDetail::create($dto['owner_detail']);
//            $citizen = Citizen::create($dto['citizen']);

            $individualBusiness->owner_detail_id = $ownerDetail->id;
//            $individualBusiness->citizen_id = $citizen->id;
            $individualBusiness->save();

            collect($dto['addresses'])->each(function ($address) use ($individualBusiness) {
               $addresses = Address::create($address);
               $individualBusiness->addresses = $addresses;
            });

            collect($dto['other_businesses'])->each(function ($otherBusiness) use ($individualBusiness) {
                $otherBusiness = OtherBusiness::create($otherBusiness);
                $individualBusiness->other_businesses = $otherBusiness;
            });

            collect($dto['director_details'])->each(function ($directorDetail) use ($individualBusiness) {
                $directorDetails = DirectorDetail::create($directorDetail);
                $individualBusiness->director_details = $directorDetails;
            });

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }


}
