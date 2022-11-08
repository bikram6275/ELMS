<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee_name' => 'required',
            'marital_status' => 'required',
            'first_entry_position' => 'required',
            'level' => 'required',
            'present_position' => 'required',
            'gender'=>'required',
            'education_type_id'=>'required',
            'education_level_id'=>'required',
            'permanent_district_id'=>'required',
            'permanent_pradesh_id'=>'required',
            'permanent_muni_id'=>'required',
            'pradesh_id'=>'required',
            'district_id'=>'required',
            'muni_id'=>'required',
            'ward_no'=>'required',
            'employee_type_id'=>'required'



        ];
    }
}
