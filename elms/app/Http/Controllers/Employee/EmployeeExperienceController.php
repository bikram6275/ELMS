<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Repository\Configurations\FiscalYearRepository;
use Illuminate\Http\Request;
use App\Repository\Employee\Experience\EmployeeExperienceRepository;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;

use App\Models\Employee\EmployeeExperience;
use Illuminate\Support\Facades\Auth;


class EmployeeExperienceController extends Controller
{
    /**
     * @var EmployeeExperienceRepository
     */
    private $employeeExperienceRepository;
    /**
     * @var EmployeeExperience
     */
    private $employeeExperience;
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var FiscalYearRepository
     */
    private $fiscalYearRepository;

    public function __construct(EmployeeExperienceRepository $employeeExperienceRepository, EmployeeExperience $employeeExperience,EmployeeRecordRepository $employeeRecordRepository,FiscalYearRepository $fiscalYearRepository)
   {

       $this->employeeExperienceRepository = $employeeExperienceRepository;
       $this->employeeExperience = $employeeExperience;
       $this->employeeRecordRepository = $employeeRecordRepository;
       $this->fiscalYearRepository = $fiscalYearRepository;
   }

    public function index()
    {
        $experience_details=$this->employeeExperienceRepository->findByOrgs();
        return view('backend.employee.experience.index',compact('experience_details'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $employees=$this->employeeRecordRepository->findByOrgs();
        $fiscalyears=$this->fiscalYearRepository->all();
        if($request->singleInput=="SingleInput"){
            return view('backend.employee.experience.createsingle', compact('employees','fiscalyears'));
        }else {
            return view('backend.employee.experience.create', compact('employees','fiscalyears'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //return $request;
            $value=$request->all();
            $countemployee=Count($request->ids);
            if($countemployee != NULL) {
                for($i=0; $i<$countemployee ;$i++){
                    $oldemployee=$this->employeeExperience->where('employee_id',$request->ids[$i])->first();
                    if(!isset($oldemployee)) {
                        $create = $this->employeeExperience->insert([
                            'employee_id' => $request->ids[$i],
                            'present_org_year' => $request->present_org_year[$i],
                            'present_org_month' => $request->present_org_month[$i],
                            'same_occu_year' => $request->same_occu_year[$i],
                            'same_occu_month' => $request->same_occu_month[$i],
                            'present_pos_year' => $request->present_pos_year[$i],
                            'present_pos_month' => $request->present_pos_month[$i],
                            'other_org_year' => $request->other_org_year[$i],
                            'other_org_month' => $request->other_org_month[$i],
                            'total_exp_year' => $request->total_exp_year[$i],
                            'total_exp_month' => $request->total_exp_month[$i],
                            'organization_id' => Auth::user()->id,
                        ]);
                    }else{
                        session()->flash('error', 'Employee Experience Details Is Already Exists');
                        return redirect(route('experience.index'));

                    }
                }

            }
            if ($create) {

                session()->flash('success', 'Employee Experience Details Added Sucessfully');
                return redirect(route('experience.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('experience.index'));
            }

        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('experience.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee_experience=$this->employeeExperienceRepository->findById($id);
        return view('backend.employee.experience.view',compact('employee_experience'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->employeeExperienceRepository->findById($id);
            $employees=$this->employeeRecordRepository->findByOrgs();

            if ($edits->count() > 0) {
                return view('backend.employee.experience.edit', compact('employees','edits'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        try {
            $employee_experience = $this->employeeExperienceRepository->findById($id);
            if ($employee_experience) {
                $value = $request->all();
                $update=$value['organization_id']=Auth::user()->id;
                $employee_experience->fill($value)->save();
                session()->flash('success', 'Employee Experience Details updated successfully!');

                return redirect(route('experience.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
        }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $value = $this->employeeExperienceRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Experience Details successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }    }
}
