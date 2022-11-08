<?php


namespace App\Repository\Employee\Administrative;
use App\Models\Employee\EmployeeAward;
use Illuminate\Support\Facades\Auth;


class EmployeeAwardRepository
{
    /**
     * @var EmployeeAward
     */
    private $employeeAward;

    public function __construct(EmployeeAward $employeeAward)
    {

        $this->employeeAward = $employeeAward;
    }
    public function all()
    {
        $result = $this->employeeAward->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findByYear($id)
    {
        $result = $this->employeeAward->where('fy_id',$id)->where('org_id',Auth::user()->id)
            ->select('fy_id','employee_id')->with('employee')->distinct()
            ->get();

        $result = $result->groupby('employee_id');
        return $result;
    }

    public function groupbyYear()
    {
        $result = $this->employeeAward->orderBy('id', 'ASC')-> select('fy_id','id')->with('fiscal')
            ->groupBy('fy_id','id')->where('org_id',Auth::user()->id)->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeAward->where('id',$id)->where('org_id',Auth::user()->id)->first();
        return $result;
    }
    public function find($id)
    {
        $result = $this->employeeAward->where('employee_id',$id)->where('org_id',Auth::user()->id);
        return $result;
    }
    public function empAward($id)
    {
        $result = $this->employeeAward->where('employee_id',$id)->where('org_id',Auth::user()->id)->get();
        return $result;
    }
    public function findFiscal($id){
        $result = $this->employeeAward->where('id',$id)->where('org_id',Auth::user()->id)->first();

        return $result;
    }

    public function findByEmplyeeId($id, $fiy_id)
    {
        $result = $this->employeeAward->where('employee_id',$id)->where('org_id',Auth::user()->id)->where('fy_id',$fiy_id)->get();
        return $result;
    }
}
