<?php

namespace App\Repository\Employee\EmployeeEducation;
use App\Models\Employee\EmployeeEducationType;
class EmployeeEducationTypeRepository
{
    /**
     * @var EmployeeEducationType
     */
    private $employeeEducationType;

    public function __construct(EmployeeEducationType $employeeEducationType){

        $this->employeeEducationType = $employeeEducationType;
    }
    public function all()
    {
        $result = $this->employeeEducationType->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeEducationType->find($id);
        return $result;
    }
    public function findtype($id)
    {
        $result = $this->employeeEducationType->orderBy('id', 'ASC')->where('id',$id)->get();
        return $result;
    }

}
