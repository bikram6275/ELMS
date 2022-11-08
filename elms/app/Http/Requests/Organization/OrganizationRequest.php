<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'org_name' => 'required|unique:organizations,org_name,'.\Request::segment(2),
            'pradesh_id' => 'required',
            'district_id' => 'required',
            'muni_id' => 'required',
            'ward_no' => 'required|numeric',
            'phone_no' => 'nullable|min:11|numeric',
            // 'email' => 'required',
            // 'fax' => 'required',
            // 'website' => 'required',
            'establish_date' => 'required',
//            'name' => 'required',
            'password' => 'required',
            'user_status' => 'required',
            'org_image' => 'mimes:jpg,jpeg,png',
            'detail' => 'required',
            'sector_id' => 'required',
            'pan_number' => 'required|numeric',
            'licensce_no' => 'required|numeric',
            // 'tole' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'pradesh_id.required' => 'The Pradesh field is required.',
            'district_id.required' => 'The District field is required.',
            'muni_id.required' => 'The Municipality field is required.',
            'sector_id.required' => 'Sector field is required.',
        ];
    }
}
