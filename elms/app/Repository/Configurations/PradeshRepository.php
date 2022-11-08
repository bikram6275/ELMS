<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\Pradesh;

class PradeshRepository
{
    /**
     * @var Pradesh
     */
    private $pradesh;


    /**
     * PradeshRepository constructor.
     */
    public function __construct(Pradesh $pradesh)
    {
        $this->pradesh = $pradesh;
    }

    public function all()
    {
        $result = $this->pradesh->orderBy('pradesh_name', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->pradesh->find($id);
        return $result;
    }
}