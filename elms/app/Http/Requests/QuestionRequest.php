<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'qsn.qsn_number' => 'required',
            'qsn.qsn_name' => 'required',
            'qsn.ans_type' => 'required',
            'qsn.qst_status' => 'required',
            'qsn.required' => 'required',
            // 'qsn.qsn_modify' => 'required',
            'qsn.qsn_order' => 'required',

            // 'option.*.option_number'=>'required',
            // 'option.*.option_name'=>'required',
            // 'option.*.option_order'=>'required|numeric',
            // 'option.*.option_type'=>'required',
        ];
    }

}
