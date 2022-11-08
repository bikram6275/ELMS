<?php

namespace App\Http\Requests\Occupation;

use Illuminate\Foundation\Http\FormRequest;

class OccupationRequest extends FormRequest
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
            'sector_id' => 'required',
            'occupation_name' => 'required',
            // 'occupation_name.*' => 'required|string|distinct',
            'occupation_name.*' => 'required|string|not_regex:/^[0-9]*$/|unique:occupations,occupation_name,'.\Request::segment(3),


        ];
    }
    public function messages()
    {
        return [
            'sector_id.required' => 'The Sector field is required.',
        ];
    }
}
