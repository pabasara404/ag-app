<?php

namespace App\Actions;

use App\DTO\FirmDTO;
use App\Models\Address;
use App\Models\Firm;
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
                'partners'
            ])
            ->get();
    }

    public static function store(array $firmData)
    {
        DB::beginTransaction();

        try {
            $dto = new FirmDTO($firmData);
            $dto->application_code = Firm::generateApplicationCode();

            $firmArray = (array) $dto;

            unset($firmArray['addresses'], $firmArray['partner_details']);

            $firm = Firm::create($firmArray);

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
