<?php

namespace App\Actions;

use App\DTO\TimberCuttingPermitApplicationDTO;
use App\DTO\TimberTransportingPermitApplicationDTO;
use App\Models\Boundaries;
use App\Models\Citizen;
use App\Models\DeedDetail;
use App\Models\GnDivision;
use App\Models\LandDetail;
use App\Models\PrivateLandDetail;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TimberDetail;
use App\Models\TimberTransportingPermitApplication;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimberTransportingPermitApplicationAction
{
    public static function all(): Collection
    {
        return TimberTransportingPermitApplication::query()->all();
    }

    public static function store(array $timberTransportingPermitApplication, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new TimberTransportingPermitApplicationDTO($timberTransportingPermitApplication);
            $timberTransportingPermitApplication = TimberTransportingPermitApplication::create($dto);
            $gnDivision = GnDivision::create($dto['gn_division']);
            $privateLand = PrivateLandDetail::create($dto['private_lands']);
            $boundaries = Boundaries::create($dto['boundaries']);
//            $citizen = Citizen::create($dto['citizen']);

            $timberTransportingPermitApplication->gn_division_id = $gnDivision->id;
            $timberTransportingPermitApplication->private_land_id = $privateLand->id;
            $timberTransportingPermitApplication->boundary_id = $boundaries->id;
//            $timberTransportingPermitApplication->citizen_id = $citizen->id;

            collect($dto['timber_details'])->each(function ($timberDetail) use ($timberTransportingPermitApplication) {
                $timberDetails = TimberDetail::create($timberDetail);
                $timberTransportingPermitApplication->timber_details()->save($timberDetails);
            });


            $timberTransportingPermitApplication->save();

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }


}
