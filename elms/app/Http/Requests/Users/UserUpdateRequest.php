<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'designation_id' => 'required',
            'user_group_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            Rule::unique('users')->ignore($this->id),
            'avatar_image' => 'mimes:jpg,jpeg,png',
            'user_status' => 'required'
        ];
    }
}
