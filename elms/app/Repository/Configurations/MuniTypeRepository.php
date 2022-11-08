<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\MuniType;

class MuniTypeRepository
{
    /**
     * @var MuniType
     */
    private $muniType;


    /**
     * MuniTypeRepository constructor.
     */
    public function __construct(MuniType $muniType)
    {
        $this->muniType = $muniType;
    }

    public function all()
    {
        $result = $this->muniType->orderBy('muni_type_name', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->muniType->find($id);
        return $result;
    }
}