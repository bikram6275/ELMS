<?php

namespace App\Http\Helpers;

use App\Models\Survey\Survey;

class SurveyHelper
{
    public function __construct(Survey $model)
    {
        $this->model = $model;
    }

    public function dropdown()
    {
       return $this->model->pluck('survey_name','id');
    }
}
