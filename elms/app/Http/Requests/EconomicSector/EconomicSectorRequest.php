<?php

namespace App\Http\Requests\EconomicSector;

use Illuminate\Foundation\Http\FormRequest;

class EconomicSectorRequest extends FormRequest
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
//            'parent_id' => 'required',
            'sector_name' => 'required|string|not_regex:/^[0-9]*$/|unique:economic_sectors,sector_name,'.\Request::segment(3),


        ];
    }
}
