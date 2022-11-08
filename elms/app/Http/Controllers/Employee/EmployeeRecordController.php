<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee\EmployeeEducation;
use App\Models\Employee\EmployeePreviousOrganization;
use App\Models\Employee\EmployeeRecord;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\GenderRepository;
use App\Repository\Configurations\MunicipalityRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Employee\Administrative\EmployeeAwardRepository;
use App\Repository\Employee\Administrative\EmployeeLeaveRepository;
use App\Repository\Employee\Administrative\EmployeePunishmentRepository;
use App\Repository\Employee\EmployeeEducation\EmployeeEducationLevelRepository;
use App\Repository\Employee\EmployeeEducation\EmployeeEducationRepository;
use App\Repository\Employee\EmployeeEducation\EmployeeEducationTypeRepository;
use App\Repository\Employee\EmployeePreviousOrg\EmployeePreviousOrgRepository;
use App\Repository\Employee\EmployeePreviousOrgRepository\EmployeePreviousOrg;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use App\Repository\Employee\EmployeeResponsibility\EmployeeResponsibilityRepository;
use App\Repository\Employee\EmployeeTraining\EmployeeTrainingRepository;
use App\Repository\Employee\EmployeeType\EmployeeTypeRepository;
use App\Repository\Employee\Experience\EmployeeExperienceRepository;
use App\Repository\Organization\OrganizationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeRecordController extends Controller
{
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var EmployeeRecord
     */
    private $employeeRecord;
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;
    /**
     * @var Organization
     */
    private $organization;
    /**
     * @var PradeshRepository
     */
    private $pradeshRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var MunicipalityRepository
     */
    private $municipalityRepository;
    /**
     * @var EmployeeTypeRepository
     */
    private $employeeTypeRepository;
    /**
     * @var EmployeePreviousOrganization
     */
    private $employeePreviousOrganization;
    /**
     * @var EmployeePreviousOrgRepository
     */
    private $employeePreviousOrgRepository;
    /**
     * @var EmployeeEducationLevelRepository
     */
    private $employeeEducationLevelRepository;
    /**
     * @var EmployeeEducationTypeRepository
     */
    private $employeeEducationTypeRepository;
    /**
     * @var EmployeeEducation
     */
    private $employeeEducation;
    /**
     * @var EmployeeEducationRepository
     */
    private $employeeEducationRepository;
    /**
     * @var GenderRepository
     */
    private $genderRepository;
    /**
     * @var EmployeeAwardRepository
     */
    private $employeeAwardRepository;
    /**
     * @var EmployeePunishmentRepository
     */
    private $employeePunishmentRepository;
    /**
     * @var EmployeeExperienceRepository
     */
    private $employeeExperienceRepository;
    /**
     * @var EmployeeTrainingRepository
     */
    private $employeeTrainingRepository;
    /**
     * @var EmployeeResponsibilityRepository
     */
    private $employeeResponsibilityRepository;
    private $employeeLeaveRepository;


    public function __construct(
        EmployeeRecordRepository         $employeeRecordRepository,
        EmployeeRecord                   $employeeRecord,
        OrganizationRepository           $organizationRepository,
        PradeshRepository                $pradeshRepository,
        DistrictRepository               $districtRepository,
        MunicipalityRepository           $municipalityRepository,
        EmployeeTypeRepository           $employeeTypeRepository,
        EmployeePreviousOrganization     $employeePreviousOrganization,
        EmployeePreviousOrgRepository    $employeePreviousOrgRepository,
        EmployeeEducationLevelRepository $employeeEducationLevelRepository,
        EmployeeEducationTypeRepository  $employeeEducationTypeRepository,
        EmployeeEducation                $employeeEducation,
        EmployeeEducationRepository      $employeeEducationRepository,
        GenderRepository                 $genderRepository,
        EmployeeAwardRepository          $employeeAwardRepository,
        EmployeePunishmentRepository     $employeePunishmentRepository,
        EmployeeExperienceRepository     $employeeExperienceRepository,
        EmployeeTrainingRepository       $employeeTrainingRepository,
        EmployeeResponsibilityRepository $employeeResponsibilityRepository,
        EmployeeLeaveRepository  $employeeLeaveRepository

    )
    {

        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->municipalityRepository = $municipalityRepository;
        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->organizationRepository = $organizationRepository;
        $this->employeeRecord = $employeeRecord;
        $this->employeeTypeRepository = $employeeTypeRepository;
        $this->employeePreviousOrganization = $employeePreviousOrganization;
        $this->employeePreviousOrgRepository = $employeePreviousOrgRepository;
        $this->employeeEducationLevelRepository = $employeeEducationLevelRepository;
        $this->employeeEducationTypeRepository = $employeeEducationTypeRepository;
        $this->employeeEducation = $employeeEducation;
        $this->employeeEducationRepository = $employeeEducationRepository;
        $this->genderRepository = $genderRepository;
        $this->employeeAwardRepository = $employeeAwardRepository;
        $this->employeePunishmentRepository = $employeePunishmentRepository;
        $this->employeeExperienceRepository = $employeeExperienceRepository;
        $this->employeeTrainingRepository = $employeeTrainingRepository;
        $this->employeeResponsibilityRepository = $employeeResponsibilityRepository;
        $this->employeeLeaveRepository = $employeeLeaveRepository;
    }

    public function index(Request $request)
    {
        $employees = $this->employeeRecordRepository->emp($request);
        $emp = $this->employeeRecordRepository->findByOrgs();
        $employeeTypes = $this->employeeTypeRepository->employeeType();
        $genders = $this->genderRepository->all();
        return view('backend.employee.employee_record.index', compact('employees', 'employeeTypes', 'genders','emp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pradeshes = $this->pradeshRepository->all();
        $genders = $this->genderRepository->all();
        $districts = $this->districtRepository->all();
        $municipalities = $this->municipalityRepository->all();
        $organizations = $this->organizationRepository->orgName();
        $employeeTypes = $this->employeeTypeRepository->employeeType();
        $eduLevels = $this->employeeEducationLevelRepository->all();
        $eduTypes = $this->employeeEducationTypeRepository->all();
        return view('backend.employee.employee_record.create', compact('pradeshes', 'districts', 'municipalities', 'organizations', 'employeeTypes', 'eduLevels', 'eduTypes', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(EmployeeRequest $request)
    {

        try {
            DB::beginTransaction();
            $result = $request->all();
            $result['organization_id'] = Auth::user()->id;
            $create = $this->employeeRecord->create($result);
            $store = $this->employeeEducation->insert([
                'employee_id' => $create->id,
                'education_type_id' => $request->education_type_id,
                'education_level_id' => $request->education_level_id,

            ]);
            //return $create;
            $organization_name = Count($request->organization_name);
            for ($i = 0; $i < $organization_name; $i++) {
                if ($request->organization_name[$i] != NULL) {
                    $add = $this->employeePreviousOrganization->insert([
                        'employee_id' => $create->id,
                        'organization_name' => $request->organization_name[$i],
                        'last_position' => $request->last_position[$i],
                        'total_experience_year' => $request->year[$i],
                        'total_experience_month' => $request->month[$i],
                    ]);
                }
            }


            DB::commit();

            if ($create) {
                session()->flash('success', 'Employee successfully created!');
                return redirect(route('employeeRecord.index'));
            } else {
                DB::rollback();
                session()->flash('error', 'Employee could not be created!');
                return redirect(route('employeeRecord.index'));
            }
        } catch (Exception $e) {
            return $e;
            DB::rollback();
            $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('employeeRecord.index'));
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
        try {
            $employee = $this->employeeRecordRepository->findById($id);

            $orgRecs = $this->employeePreviousOrgRepository->findOrgRec($employee->id);
            $empAwards = $this->employeeAwardRepository->empAward($employee->id);
            $empPunishments = $this->employeePunishmentRepository->empPunishment($employee->id);
            $empExperiences = $this->employeeExperienceRepository->empExperience($employee->id);
            $empTrainings = $this->employeeTrainingRepository->empTraining($employee->id);
            $empResponsibilitys = $this->employeeResponsibilityRepository->empResponsibility($employee->id);
            $empleaves = $this->employeeLeaveRepository->empLeave($employee->id);
            if ($employee) {
                return view('backend.employee.employee_record.show',
                    compact('employee', 'orgRecs', 'empAwards', 'empPunishments', 'empExperiences', 'empTrainings', 'empResponsibilitys','empleaves'));
            } else {
                return back();
            }
        } catch (Exception $e) {
            $e->getMessage();
            session()->flash('error', 'Something went Wrong!!');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {

        try {
            $id = (int)$id;
            $edits = $this->employeeRecordRepository->findById($id);
            $genders = $this->genderRepository->all();
            $pradeshes = $this->pradeshRepository->all();
            $districts = $this->districtRepository->findDistrict($edits->pradesh_id);
            $municipalities = $this->municipalityRepository->findMunicipality($edits->district_id);
            $organizations = $this->organizationRepository->all($request);
            $orgRecs = $this->employeePreviousOrgRepository->findOrgRec($edits->id);
            $empEdus = $this->employeeEducationRepository->findById($edits->id);
            $employeeTypes = $this->employeeTypeRepository->employeeType();
            $eduLevels = $this->employeeEducationLevelRepository->all();
            $eduTypes = $this->employeeEducationTypeRepository->all();
            if ($edits->count() > 0) {
                $employees = $this->employeeRecordRepository->all();
                return view('backend.employee.employee_record.edit',
                    compact('employees', 'edits', 'pradeshes',
                        'districts', 'municipalities', 'organizations', 'employeeTypes',
                        'orgRecs', 'empEdus', 'eduTypes', 'eduLevels', 'genders'));
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
    public function update(EmployeeRequest $request, $id)
    {
        $id = (int)$id;
        try {

            $employee = $this->employeeRecordRepository->findById($id);

            $orgRecs = $this->employeePreviousOrgRepository->findOrgRec($employee->id);
            $store = $this->employeeEducation->where('id', $request->eduId)->update([
                'employee_id' => $employee->id,
                'education_type_id' => $request->education_type_id,
                'education_level_id' => $request->education_level_id,

            ]);
            $organization_name = Count($request->organization_name);

            if ($organization_name != NULL) {
                if ($request->id) {
                    for ($i = 0; $i < $organization_name; $i++) {
                        $add = EmployeePreviousOrganization::updateOrCreate(['id' => $request->id[$i]], [
                            'employee_id' => $employee->id,
                            'organization_name' => $request->organization_name[$i],
                            'last_position' => $request->last_position[$i],
                            'total_experience_year' => $request->total_experience_year[$i],
                            'total_experience_month' => $request->total_experience_month[$i],
                        ]);


                    }
                } else {
                    for ($i = 0; $i < $organization_name; $i++) {
                        if ($request->organization_name[$i] != NULL) {
                            $add = $this->employeePreviousOrganization->insert([
                                'employee_id' => $employee->id,
                                'organization_name' => $request->organization_name[$i],
                                'last_position' => $request->last_position[$i],
                                'total_experience_year' => $request->year[$i],
                                'total_experience_month' => $request->month[$i],
                            ]);
                        }
                    }
                }

            }

            if ($employee) {
                $value = $request->all();
                $update = $value['organization_id'] = Auth::user()->id;
                $employee->fill($value)->save();
                session()->flash('success', 'Employee updated successfully!');
                return redirect(route('employeeRecord.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (Exception $e) {
            return $e;
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
            DB::beginTransaction();
            $value = $this->employeeRecordRepository->findById($id);
            $empOrg = $this->employeePreviousOrgRepository->findById($id);
            $empOrg->delete();
            $value->delete();
            DB::commit();
            session()->flash('success', 'Employee successfully deleted!');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function getEduLevel($education_type_id)
    {

        $result = $this->employeeEducationLevelRepository->findEduLevel($education_type_id);
        return response()->json($result);
    }


}
