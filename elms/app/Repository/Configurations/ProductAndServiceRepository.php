<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\ProductAndServices;

class ProductAndServiceRepository
{
    /**
     * @var Gender
     */
    private $gender;

    public function __construct(ProductAndServices $product)
    {

        $this->product = $product;
    }
    public function all()
    {
        $result = $this->product->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->product->find($id);
        return $result;
    }

    public function findBySecor($sector_id)
    {
        $result = $this->product->where('sub_sector_id',$sector_id)->get();
        return $result;
    }
}
