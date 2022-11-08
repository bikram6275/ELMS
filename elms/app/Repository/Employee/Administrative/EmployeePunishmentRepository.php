<?php


namespace App\Repository\Employee\Administrative;
use App\Models\Employee\EmployeePunishment;
use Illuminate\Support\Facades\Auth;


class EmployeePunishmentRepository
{
    /**
     * @var EmployeePunishment
     */
    private $employeePunishment;

    public function __construct(EmployeePunishment $employeePunishment)
    {

        $this->employeePunishment = $employeePunishment;
    }
    public function all()
    {
        $result = $this->employeePunishment->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function groupbyYear()
    {
        $result = $this->employeePunishment->orderBy('id', 'ASC')-> select('year','id')->groupBy('year','id')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findByYear($id)
    {
//        $result = $this->employeePunishment->orderBy('id', 'ASC')->where('year',$id)->get();
//        return $result;
        $result = $this->employeePunishment->where('year',$id)->where('organization_id',Auth::user()->id)
            ->select('year','employee_id')->with('employee')->distinct()
            ->get();
        $result = $result->groupby('employee_id');
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeePunishment->find($id);
        return $result;
    }
    public function empPunishment($id)
    {
        $result = $this->employeePunishment->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findByEmplyeeId($id, $fiy_id)
    {
        $result = $this->employeePunishment->where('employee_id',$id)->where('organization_id',Auth::user()->id)->where('year',$fiy_id)->get();
        return $result;
    }
}
