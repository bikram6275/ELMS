<?php

namespace App\Repository\Employee\EmployeeEducation;
use App\Models\Employee\EmployeeEducationLevel;
use App\Models\Employee\EmployeeEducation;
class EmployeeEducationLevelRepository
{
    /**
     * @var EmployeeEducationLevel
     */
    private $employeeEducationLevel;

    public function __construct(EmployeeEducationLevel $employeeEducationLevel)
{
    $this->employeeEducationLevel = $employeeEducationLevel;
}
    public function all()
    {
        $result = $this->employeeEducationLevel->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeEducationLevel->find($id);
        return $result;
    }
    public function findEduLevel($id)
    {
        $result = $this->employeeEducationLevel->orderBy('id', 'ASC')->where('education_type_id',$id)->get();
        return $result;
    }
    public function findEdu($id)
    {
        $result = $this->employeeEducation->orderBy('id', 'ASC')->where('education_type_id',$id)->get();
        return $result;
    }
}
