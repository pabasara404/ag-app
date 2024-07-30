<?php

namespace App\Actions;

use App\DTO\TimberCuttingPermitApplicationDTO;
use App\DTO\TimberTransportingPermitApplicationDTO;
use App\Models\Boundaries;
use App\Models\Citizen;
use App\Models\DeedDetail;
use App\Models\Firm;
use App\Models\GnDivision;
use App\Models\LandDetail;
use App\Models\PrivateLandDetail;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TimberDetail;
use App\Models\TimberTransportingPermitApplication;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use App\QueryBuilders\FirmBuilder;
use App\QueryBuilders\TimberTransportPermitApplicationBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimberTransportingPermitApplicationAction
{
    public static function all(): Collection
    {
        return TimberTransportingPermitApplication::query()->all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return TimberTransportPermitApplicationBuilder::whereStatus($statusArray)
            ->with([
                'addresses',
                'partners',
                'gn_division'
            ])
            ->get();
    }

    public static function store(array $timberTransportingPermitApplication, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            // Initialize the DTO object
            $dto = new TimberTransportingPermitApplicationDTO($timberTransportingPermitApplication);

            // Assign the generated application code to the DTO object
            $dto->application_code = TimberTransportingPermitApplication::generateApplicationCode();

            // Convert DTO to array for mass assignment
            $dtoArray = (array) $dto;

            // Create the TimberTransportingPermitApplication model instance
            $timberTransportingPermitApplication = TimberTransportingPermitApplication::create($dtoArray);

            // Create related models
            $gnDivision = GnDivision::create($dto->gn_division);
            $privateLand = PrivateLandDetail::create($dto->private_lands);
            $boundaries = Boundaries::create($dto->boundaries);

            // Associate the GN Division if it exists
            if (!empty($dto->gn_division)) {
                $gnDivision = GnDivision::find($dto->gn_division['id']);
                if ($gnDivision) {
                    $timberTransportingPermitApplication->gn_division()->associate($gnDivision);
                    $timberTransportingPermitApplication->save();
                }
            }

            // Assign related model IDs to the main model
            $timberTransportingPermitApplication->private_land_id = $privateLand->id;
            $timberTransportingPermitApplication->boundary_id = $boundaries->id;

            // Save timber details
            collect($dto->timber_details)->each(function ($timberDetail) use ($timberTransportingPermitApplication) {
                $timberDetails = TimberDetail::create($timberDetail);
                $timberTransportingPermitApplication->timber_details()->save($timberDetails);
            });

            // Save the main model
            $timberTransportingPermitApplication->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }



}
