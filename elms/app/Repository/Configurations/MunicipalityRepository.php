<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\Municipality;

class MunicipalityRepository
{
    /**
     * @var Municipality
     */
    private $municipality;


    /**
     * MunicipalityRepository constructor.
     */
    public function __construct(Municipality $municipality)
    {
        $this->municipality = $municipality;
    }

    public function all()
    {
        $result = $this->municipality->orderBy('muni_code', 'ASC')->paginate(50);
        return $result;
    }
    public function findById($id)
    {
        $result = $this->municipality->find($id);
        return $result;
    }
    public function findMunicipality($id)
    {
        $result = $this->municipality->orderBy('muni_code', 'ASC')->where('district_id',$id)->get();
        return $result;
    }
}
