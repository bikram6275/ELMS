<?php

namespace App\Http\Requests\Configurations;

use Illuminate\Foundation\Http\FormRequest;

class FiscalYearRequest extends FormRequest
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
            'fy_name' => 'required',
            'fy_start_date' => 'required',
            'fy_end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fy_name.required' => 'Fiscal year name is required. Please provide Fiscal year name.',
            'fy_start_date.required' => 'Start Year is required. Please provide Start Year.',
            'fy_end_date.required' => 'End Date is required. Please provide End Date.'
        ];
    }
}
