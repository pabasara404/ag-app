<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFirmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
//            'business_name' => 'required|string|max:255',
//            'nature' => 'required|string|max:255',
//            'principal_place' => 'required|string|max:255',
//            'initial_capital' => 'required|numeric',
//            'start_date' => 'required|date',
//            'checked_date' => 'nullable|date',
//            'comment' => 'nullable|string|max:255',
//            'is_other_business_value' => 'required|string',
//            'is_other_occupation_value' => 'required|string',
//            'ownership_of_land_checked_value' => 'required|string|max:255',
//            'status' => 'required|string|max:255',
//            'submission_timestamp' => 'nullable|date',
//            'application_code' => 'required|string|max:255',
        ];
    }
}
