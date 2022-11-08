<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\LeaveRequest;
use App\Models\Employee\EmployeeLeave;
use App\Models\Leave\Leave;
use App\Repository\Leave\LeaveRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeaveTypeController extends Controller
{
    /**
     * @var Leave
     */
    private $leave;
    /**
     * @var LeaveRepository
     */
    private $leaveRepository;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     *
     */
    public function __construct(Leave $leave, LeaveRepository $leaveRepository)
    {


        $this->leave = $leave;
        $this->leaveRepository = $leaveRepository;
    }

    public function index()
    {
        $leaves = $this->leaveRepository->all();
        return view('backend.leave.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(LeaveRequest $request)
    {
        try {
            $create = $this->leave->create($request->all());
            if ($create) {
                session()->flash('success', 'Leave Type successfully created!');
                return back();
            } else {
                session()->flash('error', 'Leave Type could not be created!');
                return back();
            }
        } catch (Exception $e) {
            $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return back();
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
        //
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
            $edits = $this->leaveRepository->findById($id);
            if ($edits->count() > 0) {
                $leaves = $this->leaveRepository->all();
                return view('backend.leave.index', compact('edits', 'leaves'));
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
    public function update(LeaveRequest $request, $id)
    {

        $id = (int)$id;
        try {
            $leaves = $this->leaveRepository->findById($id);
            if ($leaves) {
                $leaves->fill($request->all())->save();
                session()->flash('success', 'Leave updated successfully!');

                return redirect(route('leavetype.index'));
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
            $employee_leave=EmployeeLeave::where('leavetype_id',$id)->get();
            if(count($employee_leave)>0){
                session()->flash('error', 'Cannot delete this item!');
            }else{
                $value = $this->leaveRepository->findById($id);
                $value->delete();
                session()->flash('success', 'Leave type successfully deleted!');
            }
            return back();
        } catch (Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
