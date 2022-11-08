<?php


namespace App\Repository\Employee\EmployeeTraining;
use App\Models\Employee\EmployeeTraining;
use Illuminate\Support\Facades\Auth;

class EmployeeTrainingRepository
{
    /**
     * @var EmployeeTraining
     */
    private $employeeTraining;

    public function __construct(EmployeeTraining $employeeTraining)
    {

        $this->employeeTraining = $employeeTraining;
    }
    public function all()
    {
        $result = $this->employeeTraining->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findByOrgs()
    {
        $result = $this->employeeTraining->orderBy('id', 'ASC')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function employeeFind($id)
    {
        $result = $this->employeeTraining->orderBy('id', 'ASC')->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }

    public function findById($id)
    {
        $result = $this->employeeTraining->where('id',$id)->where('organization_id',Auth::user()->id)->first();

        return $result;
    }
    public function find($id)
    {
        $result = $this->employeeTraining->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();

        return $result;
    }
    public function groupbyEmployee()
    {
        $result = $this->employeeTraining->orderBy('id', 'ASC')-> select('employee_id','id')->groupBy('employee_id','id')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function empTraining($id)
    {
        $result = $this->employeeTraining->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
}
