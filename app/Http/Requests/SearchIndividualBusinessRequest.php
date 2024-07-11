<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchIndividualBusinessRequest extends FormRequest
{
/**
* Determine if the user is authorized to make this request.
*/
public function authorize()
{
return true;
}

/**
* Get the validation rules that apply to the request.
*/
public function rules()
{
return [
'application_code' => 'required|string',
];
}
}
