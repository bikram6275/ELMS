<?php

namespace App\Repository\Employee\EmployeePreviousOrg;

use App\Models\Employee\EmployeePreviousOrganization;


class EmployeePreviousOrgRepository
{
    /**
     * @var EmployeePreviousOrg
     */
    private $employeePreviousOrg;
    public function __construct(EmployeePreviousOrganization $employeePreviousOrg)
    {

        $this->employeePreviousOrg = $employeePreviousOrg;
    }
    public function findById($id)
    {
       $result = $this->employeePreviousOrg->where('employee_id',$id);
       return $result;
    }
    public function findOrgRec($id)
    {
        $result = $this->employeePreviousOrg->where('employee_id',$id)->get();
        return $result;
    }
}
