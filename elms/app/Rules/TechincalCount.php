<?php

namespace App\Rules;

use App\Models\HumanResources;
use Illuminate\Contracts\Validation\Rule;

class TechincalCount implements Rule
{
    protected $model;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(HumanResources $model)
    {
        //
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $count = $this->model->where('enumerator_assign_id',$request->pivot_id)->where('working_type','technical')->sum('total');
        return $value == $count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
