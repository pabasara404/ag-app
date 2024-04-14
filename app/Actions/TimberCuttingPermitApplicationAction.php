<?php

namespace App\Actions;

use App\DTO\TimberCuttingPermitApplicationDTO;
use App\Models\Boundaries;
use App\Models\DeedDetail;
use App\Models\GnDivision;
use App\Models\LandDetail;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use App\QueryBuilders\EmployeeBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimberCuttingPermitApplicationAction
{
    public static function all(): Collection
    {
        return TimberCuttingPermitApplication::query()->all();
    }

    public static function update(array $employee): bool
    {
        return EmployeeBuilder::whereId($employee['id'])
            ->update([
                'name' => $employee['name'],
                'address' => $employee['address'],
                'contact_number' => $employee['contact_number'],
                'date_of_birth' => $employee['date_of_birth'],
            ]);
    }

    public static function store(array $timberCuttingPermitApplication, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new TimberCuttingPermitApplicationDTO($timberCuttingPermitApplication);
            $timberCuttingPermitApplication = TimberCuttingPermitApplication::create($dto);
            $gnDivision = GnDivision::create($dto['grama_niladari_division']);
            $deedDetails = DeedDetail::create($dto['deed_details']);
            $landDetails = LandDetail::create($dto['land_details']);
            $boundaries = Boundaries::create($dto['boundaries']);

            $timberCuttingPermitApplication->gn_division_id = $gnDivision->id;
            $timberCuttingPermitApplication->deed_detail_id = $deedDetails->id;
            $timberCuttingPermitApplication->land_detail_id = $landDetails->id;
            $timberCuttingPermitApplication->boundary_id = $boundaries->id;
            $timberCuttingPermitApplication->save();

            collect($dto['tree_cutting_reasons'])->each(function ($treeCuttingReason) use ($timberCuttingPermitApplication) {
                $timberCuttingPermitApplication->treeCuttingReasons()->attach(TreeCuttingReason::find($treeCuttingReason['id']));
            });

            collect($dto['tree_details'])->each(function ($treeDetail) use ($timberCuttingPermitApplication) {
                $treeDetails = TreeDetail::create($treeDetail);
                $timberCuttingPermitApplication->tree_details = $treeDetails;
            });
            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }


}
