<?php

namespace App\Helpers;

use App\Models\Configuration\ProductAndServices;

class ServiceHelper {
    private $model;

    public function __construct(ProductAndServices $model)
    {
        $this->model = $model;
    }

    public function value($id){
        $data = $this->model->where('id',$id)->first();
        return $data->product_and_services_name;
    }
}