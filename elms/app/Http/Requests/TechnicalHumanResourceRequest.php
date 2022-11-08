<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalHumanResourceRequest extends FormRequest
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
            'technical.*.emp_code'=>'required',
            'technical.*.sector_id'=>'required',
            'technical.*.occupation_id'=>'required',
            'technical.*.working_time'=>'required',
            'technical.*.work_nature'=>'required',
            'technical.*.training'=>'required',
            'technical.*.edu_qua_id'=>'required',
            'technical.*.work_exp'=>'required',
        ];
    }
}
