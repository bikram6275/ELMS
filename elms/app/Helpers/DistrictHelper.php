<?php

namespace App\Helpers;

use App\Models\Configuration\District;

class DistrictHelper {
    private $model;

    public function __construct(District $model)
    {
        $this->model = $model;
    }

    public function dropdown(){
       return $this->model->pluck('english_name','id');
        
    }
}