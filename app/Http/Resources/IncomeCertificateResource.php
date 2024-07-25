<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeCertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'nic' => $this->nic,
            'contact_number' => $this->contact_number,
            'gn_division' => $this->gn_division ? $this->gn_division->toArray() : null,
            'purpose' => $this->purpose,
            'submitting_institute' => $this->submitting_institute,
            'total_annual_income' => $this->total_annual_income,
            'income_tax_number' => $this->income_tax_number,
            'is_samurdhi_beneficiary' => $this->is_samurdhi_beneficiary,
            'samurdhi_details' => $this->samurdhi_details ? [
                'id' => $this->samurdhi_details->id,
                'subside_amount' => $this->samurdhi_details->subside_amount,
                'is_subsidiaries_returned' => $this->samurdhi_details->is_subsidiaries_returned,
                'recommendation' => $this->samurdhi_details->recommendation,
                'checked_date' => $this->samurdhi_details->checked_date,
            ] : null,
            'incomes' => $this->incomes ? $this->incomes->toArray() : [],
            'checked_date' => $this->checked_date,
            'status' => $this->status,
            'submission_timestamp' => $this->submission_timestamp,
            'checked_time' => $this->checked_time,
            'comment' => $this->comment,
            'application_code' => $this->application_code,
            'updated_at' => $this->updated_at,
        ];
    }
}
