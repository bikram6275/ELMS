<?php

namespace App\Repository\Employee\EmployeeResponsibility;

use App\Models\Employee\EmployeeResponsibility;
use Illuminate\Support\Facades\Auth;

class EmployeeResponsibilityRepository
{
    /**
     * @var EmployeeResponsibility
     */
    private $employeeResponsibility;

    public function __construct(EmployeeResponsibility $employeeResponsibility)
    {

        $this->employeeResponsibility = $employeeResponsibility;
    }

    public function all()
    {
        $result = $this->employeeResponsibility->orderBy('id', 'ASC')->get();
        return $result;
    }

    public function findById($id)
    {
        $result = $this->employeeResponsibility->find($id);
        return $result;
    }

    public function findByOrgs()
    {
        $result = $this->employeeResponsibility->orderBy('id', 'ASC')->where('organization_id', Auth::user()->id)->get();
        return $result;
    }
    public function responsibilityType()
    {
        $result = $this->employeeResponsibility->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function empResponsibility($id)
    {
        $result = $this->employeeResponsibility->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
}
