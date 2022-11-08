<?php

namespace App\Http\Requests\Configurations;

use Illuminate\Foundation\Http\FormRequest;

class PradeshRequest extends FormRequest
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
            'pradesh_name'=>'required|string|not_regex:/^[0-9]*$/|unique:pradeshes,pradesh_name,'.\Request::segment(3)

        ];
    }

    public function messages()
    {
        return [
            'not_regex' => 'Numeric value provided. Please provide another name.',
            'pradesh_name.required' => 'Pradesh Name is required. Please provide pradesh name.',
            'unique' => 'Name already exist. Please provide another name.'
        ];
    }
}
