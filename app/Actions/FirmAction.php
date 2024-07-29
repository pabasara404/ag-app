<?php

namespace App\Actions;

use App\DTO\FirmDTO;
use App\Models\Address;
use App\Models\Firm;
use App\Models\GnDivision;
use App\Models\OtherPartneredBusiness;
use App\Models\Partner;
use App\Models\DirectorDetail;
use App\QueryBuilders\FirmBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FirmAction
{
    public static function all()
    {
        return Firm::query()->all();
    }

    public static function getApplicationByStatus(string $statuses): array|Collection
    {
        $statusArray = explode(',', $statuses);
        return FirmBuilder::whereStatus($statusArray)
            ->with([
                'addresses',
                'partners',
                'gn_division'
            ])
            ->get();
    }

    public static function store(array $firmData)
    {
        DB::beginTransaction();

        try {
            $dto = new FirmDTO($firmData);
            $dto->application_code = Firm::generateApplicationCode();

            // Convert DTO to array and remove nested arrays
            $firmArray = (array) $dto;
            unset($firmArray['addresses'], $firmArray['partner_details'], $firmArray['gn_division']);

            // Create firm
            $firm = Firm::create($firmArray);

            // Associate gn_division
            if (!empty($dto->gn_division)) {
                $gnDivision = GnDivision::find($dto->gn_division['id']);
                if ($gnDivision) {
                    $firm->gn_division()->associate($gnDivision);
                    $firm->save();
                }
            }

            // Save addresses
            foreach ($dto->addresses as $addressData) {
                $address = new Address($addressData);
                $firm->addresses()->save($address);
            }

            // Save partner details
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
