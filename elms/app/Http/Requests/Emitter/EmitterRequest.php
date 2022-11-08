<?php

namespace App\Http\Requests\Emitter;

use Illuminate\Foundation\Http\FormRequest;

class EmitterRequest extends FormRequest
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
            // 'name' => 'required',
            'name' => 'required|string|unique:emitters,name,'.\Request::segment(2),
            'phone_no' => 'required|min:10',
            // 'email' => 'required',
            // 'password' => 'required',
            // 'user_status' => 'required',
            'pradesh_id' => 'required',
            'district_id' => 'required',
            'muni_id' => 'required',
            'ward_no' => 'required|numeric',
            'supervisor_id' => 'required'

        ];
    }
    public function messages()
    {
        return [
            'pradesh_id.required' => 'The Pradesh field is required.',
            'district_id.required' => 'The District field is required.',
            'muni_id.required' => 'The Municipality field is required.',
            'supervisor_id.required' => 'The Supervisor field is required.',
        ];
    }
}
