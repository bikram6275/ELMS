<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
            'survey_year' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'survey_name'=>'required',
            'survey_name' => 'required|string|unique:surveys,survey_name,'.\Request::segment(2),

            'detail'=>'required',

        ];
    }
    public function messages()
    {
        return [
            'fy_id.required' => 'The Fiscal Year field is required.',
        ];
    }
}
