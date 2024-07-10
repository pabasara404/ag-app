<?php

namespace App\Actions;

use App\DTO\FirmDTO;
use App\DTO\IndividualBusinessDTO;
use App\Models\Address;
use App\Models\Boundaries;
use App\Models\Citizen;
use App\Models\DeedDetail;
use App\Models\DirectorDetail;
use App\Models\Firm;
use App\Models\OtherBusiness;
use App\Models\OtherPartneredBusiness;
use App\Models\OwnerDetail;
use App\Models\LandDetail;
use App\Models\IndividualBusiness;
use App\Models\Partner;
use App\Models\TreeCuttingReason;
use App\Models\TreeDetail;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FirmAction
{
    public static function all(): Collection
    {
        return Firm::query()->all();
    }


    public static function store(array $firmData)
    {
        DB::beginTransaction();

        try {
            $dto = new FirmDTO($firmData);

            $firm = Firm::create((array) $dto);

            foreach ($dto->addresses as $addressData) {
                $address = new Address($addressData);
                $firm->addresses()->save($address);
            }

            foreach ($dto->partner_details as $partnerData) {
                $partner = new Partner($partnerData);
                $firm->partners()->save($partner);

                foreach ($partnerData['other_partnered_businesses'] as $otherBusinessData) {
                    $otherBusiness = new OtherPartneredBusiness($otherBusinessData);
                    $partner->other_partnered_businesses()->save($otherBusiness);
                }

                foreach ($partnerData['director_details'] as $directorDetailData) {
                    $directorDetail = new DirectorDetail($directorDetailData);
                    $partner->director_details()->save($directorDetail);
                }
            }

            DB::commit();
            return $firm;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


}
