<?php

namespace App\Repository\Employee\EmployeeEducation;

use App\Models\Employee\EmployeeEducation;

class EmployeeEducationRepository
{
    /**
     * @var EmployeeEducation
     */
    private $employeeEducation;

    public function __construct(EmployeeEducation $employeeEducation)
    {

        $this->employeeEducation = $employeeEducation;
    }
    public function findById($id)
    {
        $result = $this->employeeEducation->where('employee_id',$id)->first();
        return $result;
    }
    public function findId($id)
    {
        $result = $this->employeeEducation->find($id);
        return $result;
    }

}
