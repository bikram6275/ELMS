<?php


namespace App\Repository\Employee\EmployeeType;

use App\Models\Employee\EmployeeType;

class EmployeeTypeRepository
{
    /**
     * @var EmployeeType
     */
    private $employeeType;
    public function __construct(EmployeeType $employeeType)
    {

        $this->employeeType = $employeeType;
    }
    public function employeeType()
    {
        $employeeTypes = $this->employeeType->orderBy('id', 'asc')->get();
        return $employeeTypes;
    }
    public function employee()
    {
        $employees = $this->employeeType->orderBy('id', 'asc')->first();
        return $employees;
    }
}