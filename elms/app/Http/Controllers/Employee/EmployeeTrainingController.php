<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeeTraining;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use App\Repository\Employee\EmployeeTraining\EmployeeTrainingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class EmployeeTrainingController extends Controller
{
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var EmployeeTraining
     */
    private $employeeTraining;
    /**
     * @var EmployeeTrainingRepository
     */
    private $employeeTrainingRepository;

    public function __construct(EmployeeRecordRepository $employeeRecordRepository, EmployeeTraining $employeeTraining, EmployeeTrainingRepository $employeeTrainingRepository)
    {

        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->employeeTraining = $employeeTraining;
        $this->employeeTrainingRepository = $employeeTrainingRepository;
    }

    public function view($id)
    {
        $employees = $this->employeeTrainingRepository->employeeFind($id);
        return view('backend.employee.training.indexnew', compact('employees'));


    }
    public function index()
    {
        $employees=$this->employeeTrainingRepository->groupbyEmployee();
        return view('backend.employee.training.index',compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $employees = $this->employeeRecordRepository->findByOrgs();
        $trainings = ['apprenticeship' => 'Apprenticeship', 'ojt' => 'OJT', 'occupational' => 'Occupational', 'management' => 'Management', 'others' => 'Others'];
        return view('backend.employee.training.create', compact('employees', 'trainings'));
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
            $user = Auth::user()->id;
            $countemployee = count($request->training_type);

            if ($countemployee != NULL) {
                for ($i = 0; $i < $countemployee; $i++) {
                    $create = $this->employeeTraining->insert([
                        'employee_id' => $request->employee_id,
                        'training_type' => $request->training_type[$i],
                        'pre_service_yr' => $request->pre_service_yr[$i],
                        'pre_service_month' => $request->pre_service_month[$i],
                        'in_service_yr' => $request->in_service_yr[$i],
                        'in_service_month' => $request->in_service_month[$i],
                        'others' => $request->others[$i],
                        'organization_id' => $user,
                    ]);
                }
            }

            if ($create) {
                session()->flash('success', 'Employee Training Sucessfully Added');
                return redirect(route('training.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('training.index'));
            }

        } catch (Exception $e) {
            return $e;
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('training.index'));
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
        $id = (int)$id;
        $shows = $this->employeeTrainingRepository->findById($id);
        return view('backend.employee.training.view', compact('shows'));
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
            $edits = $this->employeeTrainingRepository->findById($id);
            $employees = $this->employeeRecordRepository->findByOrgs();

            $trainings = ['apprenticeship' => 'Apprenticeship', 'ojt' => 'OJT', 'occupational' => 'Occupational', 'management' => 'Management', 'others' => 'Others'];

            if ($edits->count() > 0) {
                return view('backend.employee.training.edit', compact('edits', 'employees', 'trainings'));
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
            $employee_training = $this->employeeTrainingRepository->findById($id);
            if ($employee_training) {
                $value = $request->all();
                if ($request->training_type != 'others') {
                    $update = $value['organization_id'] = Auth::user()->id;
                    $update = $value['others'] = null;
                    $employee_training->fill($value)->save();
                    session()->flash('success', 'Employee Leave Detail updated successfully!');
                } else {
                    $update = $value['organization_id'] = Auth::user()->id;
                    $employee_training->fill($value)->save();
                    session()->flash('success', 'Employee Leave Detail updated successfully!');
                }


                return redirect(route('training.index'));
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
            $value = $this->employeeTrainingRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Training Details successfully deleted!');
            return back();
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
