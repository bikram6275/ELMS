<?php


namespace App\Repository\Employee\Administrative;
use App\Models\Employee\EmployeeLeave;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveRepository
{

    /**
     * @var EmployeeLeave
     */
    private $employeeLeave;

    public function __construct(EmployeeLeave $employeeLeave )
    {
        $this->employeeLeave = $employeeLeave;
    }
    public function all()
    {
        $result = $this->employeeLeave->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function groupbyYear()
    {
        $result = $this->employeeLeave->orderBy('id', 'ASC')-> select('year','id')->groupBy('year','id')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findByYear($id)
    {
        $result = $this->employeeLeave->orderBy('id', 'ASC')->where('year',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeLeave->find($id);
        return $result;
    }

    public function empLeave($id)
    {
        $result = $this->employeeLeave->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }

}
