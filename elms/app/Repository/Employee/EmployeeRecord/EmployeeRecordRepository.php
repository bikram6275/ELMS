<?php


namespace App\Repository\Employee\EmployeeRecord;
use App\Models\Employee\EmployeeRecord;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class EmployeeRecordRepository
{
    /**
     * @var EmployeeRecord
     */
    private $employeeRecord;

    public function __construct(EmployeeRecord $employeeRecord)
    {

        $this->employeeRecord = $employeeRecord;
    }
    public function all()
    {
        $result = $this->employeeRecord->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findByOrgs()
    {
        $result = $this->employeeRecord->orderBy('id', 'ASC')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function emp($request)
    {
        $result= $this->employeeRecord;
        if (isset($request->employee_id) && $request->employee_id != null) {
            $result = $result->where('id', $request->employee_id);
        }
        if (isset($request->employee_type_id) &&  $request->employee_type_id != null) {
            $result = $result->where('employee_type_id', $request->employee_type_id);
        }
        if (isset($request->gender)  && $request->gender != null) {
            $result = $result->where('gender', $request->gender);
        }
        $result = $result->orderBy('id', 'ASC')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeRecord->find($id);
        return $result;
    }


    public function empTypeReport()
    {
       $data=$this->employeeRecord->select('employee_type_id',DB::raw("COUNT('answers.employee_type_id ') as count"))->groupBy('employee_type_id')->get();
       return $data;
    }
}
