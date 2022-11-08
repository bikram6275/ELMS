<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\Designation;

class DesignationRepository
{

    /**
     * @var Designation
     */
    private $designation;

    public function __construct(Designation $designation)
    {
        $this->designation = $designation;
    }

    public function all()
    {
        $designation = $this->designation->orderBy('designation_name', 'ASC')->get();
        return $designation;
    }
    public function findById($id)
    {
        $designation = $this->designation->find($id);
        return $designation;
    }
}