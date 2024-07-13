<?php

namespace App\Actions;

use App\DTO\IncomeCertificateDTO;
use App\Models\IncomeCertificate;
use App\Models\Income;
use App\Models\SamurdhiDetail;
use App\Models\GNDivision;
use App\Models\User;
use App\QueryBuilders\IncomeCertificateBuilder;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IncomeCertificateAction
{
    public static function all(): Collection
    {
        return IncomeCertificate::all();
    }

    public static function getApplicationByStatus(string $statuses): array|\Illuminate\Database\Eloquent\Collection
    {
        $statusArray = explode(',', $statuses);
        return IncomeCertificateBuilder::whereStatus($statusArray)
            ->with(['incomes', 'samurdhi_details', 'gn_division'])
            ->get();
    }

    public static function store(array $incomeCertificate, User $authUser = null)
    {
        DB::beginTransaction();
        try {
            $dto = (array) new IncomeCertificateDTO($incomeCertificate);
            $dto['application_code'] = IncomeCertificate::generateApplicationCode();
            $incomeCertificate = IncomeCertificate::create($dto);

            if ($dto['is_samurdhi_beneficiary']) {
                $samurdhiDetail = new SamurdhiDetail($dto['samurdhi_details']);
                $samurdhiDetail->income_certificate_id = $incomeCertificate->id;
                $samurdhiDetail->save();
            }

            collect($dto['incomes'])->each(function ($income) use ($incomeCertificate) {
                $income['income_certificate_id'] = $incomeCertificate->id;
                $income = Income::create($income);
            });

            $gnDivision = GNDivision::find($dto['gn_division']['id']);
            $incomeCertificate->gn_division()->associate($gnDivision);
            $incomeCertificate->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

}
