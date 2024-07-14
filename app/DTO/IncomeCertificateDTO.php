<?php

namespace App\DTO;

class IncomeCertificateDTO
{
    public string $name;
    public string $address;
    public string $nic;
    public string $contact_number;
    public array $gn_division;
    public string $purpose;
    public string $submitting_institute;
    public array $incomes;
    public string $total_annual_income;
    public ?string $income_tax_number;
    public string $is_samurdhi_beneficiary;
    public array $samurdhi_details;
    public string $checked_date;
    public ?string $checked_time;
    public ?string $comment;
    public string $status;
    public ?string $submission_timestamp;
    public ?string $application_code;

    public function __construct(array $data)
    {
        collect($data)->each(function ($value, $key) {
            if ($key === 'id' && empty($value)) {
                $this->id = null;
            } elseif ($key === 'submission_timestamp' && empty($value)) {
                $this->submission_timestamp = now()->toDateTimeString();
            } else {
                $this->{$key} = $value;
            }
        });

        return $this;
    }
}
