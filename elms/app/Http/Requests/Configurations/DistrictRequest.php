<?php

namespace App\Http\Requests\Configurations;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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
            'pradesh_id'=>'required',
            'district_code'=>'required|unique:districts,district_code,'.\Request::segment(3),
            'nepali_name'=>'required|string|not_regex:/^[0-9]*$/|unique:districts,nepali_name,'.\Request::segment(3)
        ];
    }

    public function messages()
    {
        return [
            'not_regex' => 'Numeric value provided. Please provide another name.',
            'pradesh_id.required' => 'Pradesh Name is required',
            'district_code.required' => 'District code is required',
            'nepali_name.required' => 'Nepali Name is required. Please provide name.',
            'unique' => 'Name already exist. Please provide another name.',
            'district_code.unique' => 'Code already exist. Please provide another code.',
        ];
    }
}
