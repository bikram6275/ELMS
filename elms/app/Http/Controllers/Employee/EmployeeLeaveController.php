<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeeLeave;
use App\Repository\Configurations\FiscalYearRepository;
use App\Repository\Employee\Administrative\EmployeeLeaveRepository;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use App\Repository\Employee\LeaveType\EmployeeLeaveTypeRepository;
use App\Repository\Leave\LeaveRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{

    /**
     * @var EmployeeLeaveRepository
     */
    private $employeeLeaveRepository;
    /**
     * @var EmployeeLeaveTypeRepository
     */
    private $employeeLeaveTypeRepository;
    /**
     * @var EmployeeLeave
     */
    private $employeeLeave;
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var LeaveRepository
     */
    private $leaveRepository;
    /**
     * @var FiscalYearRepository
     */
    private $fiscalYearRepository;

    public function __construct(EmployeeLeaveRepository     $employeeLeaveRepository, LeaveRepository $leaveRepository,
                                EmployeeLeaveTypeRepository $employeeLeaveTypeRepository, FiscalYearRepository $fiscalYearRepository,
                                EmployeeLeave               $employeeLeave, EmployeeRecordRepository $employeeRecordRepository)
    {

        $this->employeeLeaveRepository = $employeeLeaveRepository;
        $this->employeeLeaveTypeRepository = $employeeLeaveTypeRepository;
        $this->employeeLeave = $employeeLeave;
        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->leaveRepository = $leaveRepository;
        $this->fiscalYearRepository = $fiscalYearRepository;
    }

    public function index()
    {
        $employee_leaves = $this->employeeLeaveRepository->groupbyYear();
        return view('backend.employee.administrative.employeeleave.indexnew', compact('employee_leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $employees = $this->employeeRecordRepository->findByOrgs();
        $leave_types = $this->leaveRepository->all();
        $fiscalyears = $this->fiscalYearRepository->all();
        if ($request->singleInput == "SingleInput") {
            return view('backend.employee.administrative.employeeleave.createsingle', compact('leave_types', 'employees', 'fiscalyears'));
        }
        return view('backend.employee.administrative.employeeleave.create', compact('leave_types', 'employees', 'fiscalyears'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {

            $value = $request->all();
            $countemployee = Count($request->ids);
            if ($countemployee != NULL) {
                for ($i = 0; $i < $countemployee; $i++) {
                    $oldemployee=$this->employeeLeave->where('employee_id',$request->ids[$i])->where('leavetype_id',$request->leavetype_id[$i])->where('year',$request->year)->first();
                    if(!isset($oldemployee)) {
                        $create = $this->employeeLeave->insert([
                            'employee_id' => $request->ids[$i],
                            'paid_leave' => $request->paid_leave[$i],
                            'paid_leave_used' => $request->paid_leave_used[$i],
                            'leavetype_id' => $request->leavetype_id[$i],
                            'organization_id' => Auth::user()->id,
                            'year' => $request->year,
                        ]);
                    }else{
                        session()->flash('error', 'Leave Is Already Exist');
                        return redirect(route('leave.index'));

                    }
                }
            }

            if ($create) {
                session()->flash('success', 'Employee Leave Sucessfully Added');
                return redirect(route('leave.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('leave.index'));
            }

        } catch (Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('leave.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $employee_leaves = $this->employeeLeaveRepository->findByYear($id);
        return view('backend.employee.administrative.employeeleave.show', compact('employee_leaves'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->employeeLeaveRepository->findById($id);
            $leave_types = $this->leaveRepository->findById($edits->leavetype_id);
            $fiscalyears = $this->fiscalYearRepository->findById($edits->year);
            $employees = $this->employeeRecordRepository->findByOrgs();
            if ($edits->count() > 0) {
                return view('backend.employee.administrative.employeeleave.edit', compact('edits', 'employees', 'leave_types', 'fiscalyears'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return back();
            }
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        try {
            $employee_leave = $this->employeeLeaveRepository->findById($id);

            if ($employee_leave) {
                $value = $request->all();
                $update = $value['organization_id'] = Auth::user()->id;
                $employee_leave->fill($value)->save();
                session()->flash('success', 'Employee Leave Detail updated successfully!');

                return redirect(route('leave.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $value = $this->employeeLeaveRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Leave Detail successfully deleted!');
            return back();
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
