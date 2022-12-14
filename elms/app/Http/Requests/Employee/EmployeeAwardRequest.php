<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeAwardRequest extends FormRequest
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
            'fy_id' => 'required',
            'grade_earned' => 'required',
            'promotion_received' => 'required',
            'appreciation_letter' => 'required',
            'employee_of_yr' => 'required',

        ];
    }
}
