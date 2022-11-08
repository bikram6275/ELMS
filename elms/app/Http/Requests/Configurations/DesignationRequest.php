<?php

namespace App\Http\Requests\Configurations;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'designation_name' => 'required|string|not_regex:/^[0-9]*$/|unique:designations,designation_name,'.\Request::segment(3),
            'designation_short_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'not_regex' => 'Numeric value provided. Please provide another name.',
            'designation_name.required' => 'Designation Name is required. Please provide designation name.',
            'designation_short_name.required' => 'Short Name is required. Please provide short name.',
            'unique' => 'Name already exist. Please provide another name.'
        ];
    }
}
