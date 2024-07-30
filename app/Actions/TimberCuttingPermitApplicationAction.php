<?php

namespace App\Actions;

use App\DTO\TimberCuttingPermitApplicationDTO;
use App\Models\Boundaries;
use App\Models\Citizen;
use App\Models\DeedDetail;
use App\Models\GnDivision;
use App\Models\LandDetail;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use App\QueryBuilders\TimberCuttingPermitApplicationBuilder;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimberCuttingPermitApplicationAction
{
    public static function all(): Collection
    {
        return TimberCuttingPermitApplication::query()->all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return TimberCuttingPermitApplicationBuilder::whereStatus($statusArray)
            ->with([
                "gn_division",
                "tree_details",
                "deed_detail",
                "land_detail",
                "boundary",
                "tree_cutting_reasons"
            ])
            ->get();
    }

//    public static function update(array $employee): bool
//    {
//        return EmployeeBuilder::whereId($employee['id'])
//            ->update([
//                'name' => $employee['name'],
//                'address' => $employee['address'],
//                'contact_number' => $employee['contact_number'],
//                'date_of_birth' => $employee['date_of_birth'],
//            ]);
//    }

    public static function store(array $timberCuttingPermitApplication, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = new TimberCuttingPermitApplicationDTO($timberCuttingPermitApplication);

            // Generate application code before creating the model
            $applicationCode = TimberCuttingPermitApplication::generateApplicationCode();
            $dto->application_code = $applicationCode;

            // Convert DTO to array and merge with additional fields
            $timberCuttingPermitApplicationArray = array_merge((array) $dto, [
                'application_code' => $applicationCode
            ]);

            // Create the TimberCuttingPermitApplication model with the generated application code
            $timberCuttingPermitApplication = TimberCuttingPermitApplication::create($timberCuttingPermitApplicationArray);

            $gnDivision = GnDivision::create($dto->gn_division);
            $deedDetails = DeedDetail::create($dto->deed_detail);
            $landDetails = LandDetail::create($dto->land_detail);
            $boundaries = Boundaries::create($dto->boundary);

            if (!empty($dto->gn_division)) {
                $gnDivision = GnDivision::find($dto->gn_division['id']);
                if ($gnDivision) {
                    $timberCuttingPermitApplication->gn_division()->associate($gnDivision);
                    $timberCuttingPermitApplication->save();
                }
            }

            $timberCuttingPermitApplication->deed_detail_id = $deedDetails->id;
            $timberCuttingPermitApplication->land_detail_id = $landDetails->id;
            $timberCuttingPermitApplication->boundary_id = $boundaries->id;
            $timberCuttingPermitApplication->save();

            collect($dto->tree_cutting_reasons)->each(function ($treeCuttingReason) use ($timberCuttingPermitApplication) {
                $timberCuttingPermitApplication->tree_cutting_reasons()->attach(TreeCuttingReason::find($treeCuttingReason['id']));
            });

            collect($dto->tree_details)->each(function ($treeDetail) use ($timberCuttingPermitApplication) {
                $treeDetails = TreeDetail::create($treeDetail);
                $timberCuttingPermitApplication->tree_details = $treeDetails;
            });

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }


}
