<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ResponsibilityRequest;
use App\Models\Employee\EmployeeResponsibility;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use App\Repository\Employee\EmployeeResponsibility\EmployeeResponsibilityRepository;
use App\Repository\Employee\EmployeeResponsibility\ResponsibilityRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeResponsibilityController extends Controller
{
    /**
     * @var EmployeeResponsibilityRepository
     */
    private $employeeResponsibilityRepository;
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var ResponsibilityRepository
     */
    private $responsibilityRepository;
    /**
     * @var EmployeeResponsibility
     */
    private $employeeResponsibility;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(EmployeeResponsibility $employeeResponsibility, ResponsibilityRepository $responsibilityRepository, EmployeeRecordRepository $employeeRecordRepository, EmployeeResponsibilityRepository $employeeResponsibilityRepository)
    {

        $this->employeeResponsibilityRepository = $employeeResponsibilityRepository;
        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->responsibilityRepository = $responsibilityRepository;
        $this->employeeResponsibility = $employeeResponsibility;
    }

    public function index()
    {
        $responsibilities = $this->employeeResponsibilityRepository->findByOrgs();
        return view('backend.employee.responsibility.index', compact('responsibilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $responsibility = $this->responsibilityRepository->all();
        $employees = $this->employeeRecordRepository->findByOrgs();
        return view('backend.employee.responsibility.create', compact('employees', 'responsibility'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ResponsibilityRequest $request)
    {
        try {
            $oldemployee=$this->employeeResponsibility->where('employee_id',$request->employee_id)->first();
           if(!isset($oldemployee)) {
               $result = $request->all();
               $result['organization_id'] = Auth::user()->id;
               $create = $this->employeeResponsibility->create($result);
               if ($create) {
                   session()->flash('success', 'Employee responsibility Sucessfully Added');
                   return redirect(route('responsibility.index'));
               } else {
                   session()->flash('error', 'could not be created!');
                   return redirect(route('responsibility.index'));
               }
           }else{
               session()->flash('error', 'Responsibility Is Already Assigned');
               return redirect(route('responsibility.index'));

           }
        } catch (Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('responsibility.index'));
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
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $id = (int)$id;
        try {
            $edits = $this->employeeResponsibilityRepository->findById($id);
            $employees = $this->employeeRecordRepository->findByOrgs();
            $responsibility = $this->responsibilityRepository->all();

            if ($edits->count() > 0) {
                return view('backend.employee.responsibility.edit', compact('edits', 'employees', 'responsibility'));
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
            $employee_responsibility = $this->employeeResponsibilityRepository->findById($id);
            if ($employee_responsibility) {
                $value = $request->all();
                $update = $value['organization_id'] = Auth::user()->id;
                $employee_responsibility->fill($value)->save();
                session()->flash('success', 'Employee Responsibiliity updated successfully!');

                return redirect(route('responsibility.index'));
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
            $value = $this->employeeResponsibilityRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Responsibility Detail successfully deleted!');
            return back();
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
