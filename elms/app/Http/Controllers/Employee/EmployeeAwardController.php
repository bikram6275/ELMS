<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeeAward;
use App\Repository\Configurations\FiscalYearRepository;
use App\Repository\Employee\Administrative\EmployeeAwardRepository;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeAwardController extends Controller
{
    /**
     * @var EmployeeAwardRepository
     */
    private $employeeAwardRepository;
    /**
     * @var EmployeeAward
     */
    private $employeeAward;
    /**
     * @var EmployeeRecordRepository
     */
    private $employeeRecordRepository;
    /**
     * @var FiscalYearRepository
     */
    private $fiscalYearRepository;

    public function __construct(EmployeeAwardRepository $employeeAwardRepository, EmployeeAward $employeeAward, EmployeeRecordRepository $employeeRecordRepository, FiscalYearRepository $fiscalYearRepository)
    {

        $this->employeeAwardRepository = $employeeAwardRepository;
        $this->employeeAward = $employeeAward;
        $this->employeeRecordRepository = $employeeRecordRepository;
        $this->fiscalYearRepository = $fiscalYearRepository;
    }

    public function index()
    {

        $award_details = $this->employeeAwardRepository->groupbyYear();
        return view('backend.employee.administrative.employeeaward.indexnew', compact('award_details'));
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
            return view('backend.employee.administrative.employeeaward.createsingle', compact('employees', 'fiscalyears'));
        } else {
            return view('backend.employee.administrative.employeeaward.create', compact('employees', 'fiscalyears'));
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
            $countemployee = Count($request->appreciation_letter);
            if ($countemployee != NULL) {
                for ($i = 0; $i < $countemployee; $i++) {
                    $create = $this->employeeAward->insert([
                        'employee_id' => $request->ids[$i],
                        'org_id' => Auth::user()->id,
                        'grade_earned' => $request->grade_earned[$i],
                        'promotion_received' => $request->promotion_received[$i],
                        'appreciation_letter' => $request->appreciation_letter[$i],
                        'employee_of_yr' => $request->employee_of_yr[$i],
                        'fy_id' => $request->fy_id,
                    ]);
                }

            }
            if ($create) {

                session()->flash('success', 'Employee Award Details Added Sucessfully');
                return redirect(route('award.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('award.index'));
            }

        } catch (Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('award.index'));
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
        $award_details = $this->employeeAwardRepository->findByYear($id);

        return view('backend.employee.administrative.employeeaward.show', compact('award_details'));
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
            $edits = $this->employeeAwardRepository->findByEmplyeeId($id, $request->fiscal);
            $employees = $this->employeeRecordRepository->findByOrgs();
            $fiscalyears = $this->fiscalYearRepository->all();
            if ($edits->count() > 0) {
                return view('backend.employee.administrative.employeeaward.edit', compact('employees', 'edits', 'fiscalyears'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e;
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

            try {
                $award_detail=$this->employeeAwardRepository->findById($request->id);
                if ($award_detail) {
                    $value = $request->all();
                   $value['org_id'] = Auth::user()->id;
                    $award_detail->fill($value)->save();
                    session()->flash('success', 'Employee Award Details updated successfully!');
                    return redirect(route('award.index'));

                } else {

                    session()->flash('error', 'No record with given id!');
                    return back();
                }
            }catch (Exception $e) {
                $exception = $e->getMessage();
                session()->flash('error', 'EXCEPTION:' . $exception);
                return redirect()->back();
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
            $value = $this->employeeAwardRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Employee Award Details successfully deleted!');
            return redirect(route('award.index'));
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function view(Request $request, $id)
    {
        $award_details = $this->employeeAwardRepository->findByEmplyeeId($id, $request->fiscal);
        return view('backend.employee.administrative.employeeaward.view', compact('award_details'));
    }
}
