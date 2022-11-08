<?php

namespace App\Helpers;

use App\Models\Configuration\Pradesh;

class PradeshHelper {
    private $model;

    public function __construct(Pradesh $model)
    {
        $this->model = $model;
    }

    public function dropdown(){
        return $this->model->pluck('pradesh_name','id');
    }
}