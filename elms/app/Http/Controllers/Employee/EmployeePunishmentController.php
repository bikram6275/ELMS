<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeePunishment;
use App\Repository\Configurations\FiscalYearRepository;
use App\Repository\Employee\Administrative\EmployeePunishmentRepository;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class EmployeePunishmentController extends Controller
{
    /**
     * @var EmployeePunishmentRepository
     */
    private $employeePunishmentRepository;
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var EmployeePunishment
     */
    private $employeePunishment;
    /**
     * @var FiscalYearRepository
     */
    private $fiscalYearRepository;

    public function __construct(EmployeePunishmentRepository $employeePunishmentRepository, EmployeeRecordRepository $employeeRecordRepository,
                                EmployeePunishment           $employeePunishment, FiscalYearRepository $fiscalYearRepository)
    {

        $this->employeePunishmentRepository = $employeePunishmentRepository;
        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->employeePunishment = $employeePunishment;
        $this->fiscalYearRepository = $fiscalYearRepository;
    }

    public function index()
    {
        $employee_punishments = $this->employeePunishmentRepository->groupbyYear();
        return view('backend.employee.administrative.employeepunishment.indexnew', compact('employee_punishments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $employees = $this->employeeRecordRepository->findByOrgs();

        $fiscalyears = $this->fiscalYearRepository->all();
        if ($request->singleInput == "SingleInput") {
            return view('backend.employee.administrative.employeepunishment.createsingle', compact('employees', 'fiscalyears'));
        } else {
            return view('backend.employee.administrative.employeepunishment.create', compact('employees', 'fiscalyears'));
        }
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
            $punishmentAvatarName = NUll;
            $countemployee = Count($request->grade_deducted);
            if ($countemployee != NULL) {
                for ($i = 0; $i < $countemployee; $i++) {
                    if (isset($request->punishment_img)) {
                        $year = $request->year;
                        $id = $request->ids;
                        $employeeName = $this->employeeRecordRepository->findById($id);
                        $empName = $employeeName->employee_name;
                        $punishmentImg = $request->file('punishment_img')[$i];
                        $avatarExtension = $punishmentImg->getClientOriginalExtension();
                        $punishmentAvatarName = $empName . time() . '.' . strtolower($avatarExtension);
                        $value['punishment_img'] = $punishmentAvatarName;
                        $orgName = Auth::user()->org_name;
                        Storage::putFileAs('public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/' . $id . '/', $punishmentImg, $punishmentAvatarName);
                    }

                    $create = $this->employeePunishment->insert([

                        'employee_id' => $request->ids,
                        'defence_letter_received' => $request->defence_letter_received[$i],
                        'de_promoted' => $request->de_promoted[$i],
                        'grade_deducted' => $request->grade_deducted[$i],
                        'organization_id' => Auth::user()->id,
                        'year' => $request->year,
                        'punishment_img' => $punishmentAvatarName
                    ]);
                }

            }
            if ($create) {

                session()->flash('success', 'Employee Punishment Details Added Sucessfully');
                return redirect(route('punishment.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('punishment.index'));
            }

        } catch (Exception $e) {
            return $e;
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('punishment.index'));
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
        $employee_punishments = $this->employeePunishmentRepository->findByYear($id);

        return view('backend.employee.administrative.employeepunishment.show', compact('employee_punishments'));
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
            $edits = $this->employeePunishmentRepository->findByEmplyeeId($id, $request->fiscal);
            $fiscalyears = $this->fiscalYearRepository->all();
            $employees = $this->employeeRecordRepository->findByOrgs();
            if ($edits->count() > 0) {
                return view('backend.employee.administrative.employeepunishment.edit', compact('employees', 'edits', 'fiscalyears'));
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
    public function update(Request $request)
    {

        if ($request->submit == 'update') {
            try {
                foreach ($request->id as $key => $i) {
                    if (!empty($request->punishment_img[$key])) {
                        $empName = $request->employee_name;
                        $year = $request->year;
                        $punishmentImg = $request->file('punishment_img')[$key];
                        $avatarExtension = $punishmentImg->getClientOriginalExtension();
                        $punishmentAvatarName = $empName . time() . '.' . strtolower($avatarExtension);
                        //$value['punishment_img'] = $punishmentAvatarName;
                        $orgName = Auth::user()->org_name;
                        if (isset($punishmentAvatarName)) {
                            Storage::delete('public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/' . $request->employee_id[$key]);
                            @unlink(storage_path() . '/app/public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/', $request->punishment_img[$key]);
                            Storage::putFileAs('public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/' . $request->employee_id[$key] . '/', $punishmentImg, $punishmentAvatarName);

                        }
                    }
                    $award_detail = $this->employeePunishment::where('id', $i)->update([
                        'employee_id' => $request->employee_id[$key],
                        'defence_letter_received' => $request->defence_letter_received[$key],
                        'de_promoted' => $request->de_promoted[$key],
                        'grade_deducted' => $request->grade_deducted[$key],
                        'organization_id' => Auth::user()->id,
                        'year' => $request->fy_id[$key],
                        'punishment_img'=>$punishmentAvatarName
                    ]);
                    session()->flash('success', 'Employee Award Details updated successfully!');
                    return back();
                }
            } catch (Exception $e) {
                return $e;
                $exception = $e->getMessage();
                session()->flash('error', 'EXCEPTION:' . $exception);
                return back();
            }
        } else {
            return $this->destroy($request->submit);
        }
//        return "hii";
//        $id = (int)$id;
//        try {
//            $punishment_detail = $this->employeePunishmentRepository->findById($id);
//            if ($punishment_detail) {
//                $value = $request->all();
//                if (!empty($request->file('punishment_img'))) {
//                    $empName = $request->employee_name;
//                    $year = $request->year;
//                    $punishmentImg = $request->file('punishment_img');
//                    $avatarExtension = $punishmentImg->getClientOriginalExtension();
//                    $punishmentAvatarName = $empName . time() . '.' . strtolower($avatarExtension);
//                    $value['punishment_img'] = $punishmentAvatarName;
//                    $orgName = Auth::user()->org_name;
//                }
//                $update = $value['organization_id'] = Auth::user()->id;
//                $punishment_detail->fill($value)->save();
//                if (isset($punishmentAvatarName)) {
//                    if ($punishment_detail->punishment_img != null) {
//                        Storage::delete('public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/' . $punishment_detail->employee_id);
//                        @unlink(storage_path() . '/app/public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/', $punishment_detail->punishment_img);
//                        Storage::putFileAs('public/uploads/punishmentDoc/' . $orgName . '/' . $year . '/' . $punishment_detail->employee_id . '/', $punishmentImg, $punishmentAvatarName);
//                        session()->flash('success', 'Employee Award Details updated successfully!');
//                    }
//                }
//                return redirect(route('punishment.index'));
//            } else {
//
//                session()->flash('error', 'No record with given id!');
//                return back();
//            }
//        } catch (Exception $e) {
//            $exception = $e->getMessage();
//            session()->flash('error', 'EXCEPTION:' . $exception);
//            return back();
//        }
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
            $value = $this->employeePunishmentRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Punishment Details successfully deleted!');
            return redirect(route('punishment.index'));
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function view(Request $request, $id)
    {
        $employee_punishments = $this->employeePunishmentRepository->findByEmplyeeId($id, $request->fiscal);
        return view('backend.employee.administrative.employeepunishment.view', compact('employee_punishments'));
    }
}
