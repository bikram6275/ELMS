<?php

namespace App\Http\Controllers;

use App\Models\CoordinatorSupervisor;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\CoordinatorSupervisorRepository;
use App\Repository\Survey\SurveyRepository;
use Illuminate\Http\Request;

class CoordintorSupevisorController extends Controller
{
    protected $model;

    protected $coordinator_supervisor;

    protected $surveyRepository;

    public function __construct(CoordinatorSupervisor $model, CoordinatorSupervisorRepository $coordinator_supervisor, SurveyRepository $surveyRepository)
    {
        $this->model = $model;
        $this->coordinator_supervisor = $coordinator_supervisor;
        $this->surveyRepository = $surveyRepository;
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->coordinator_supervisor->all();
        $coordinators = $this->coordinator_supervisor->coordinators();
        $supervisors = $this->coordinator_supervisor->supervisors();
        $surveys = $this->surveyRepository->all();
        return view('backend.coordinator_supervisor.index', compact('rows', 'coordinators', 'supervisors', 'surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model->create($request->all());
        session()->flash('success', 'Supervisor Assigned Successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rows = $this->coordinator_supervisor->all();

        $edits = $this->coordinator_supervisor->findById($id);
        if ($edits) {
            $coordinators = $this->coordinator_supervisor->coordinators();
            $supervisors = $this->coordinator_supervisor->supervisors();
            $surveys = $this->surveyRepository->all();
            return view('backend.coordinator_supervisor.index', compact('rows', 'edits', 'coordinators', 'supervisors', 'surveys'));
        } else {
            session()->flash('error', 'Id could not be obtained!');
            return redirect()->route('coordinator_supervisor.index');
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
        $model = $this->coordinator_supervisor->findById($id);
        if ($model) {
            $this->model->update($request->all());
            session()->flash('success', 'Coordinator wise supervisor updated successfully');
            return redirect()->back();
        } else {
            session()->flash('error', 'Id could not be obtained!');
            return redirect()->route('coordinator_supervisor.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->coordinator_supervisor->findById($id);
        $model->delete();
        session()->flash('success', 'Coordinator wise supervisor deleted successfully');
        return redirect()->back();
    }


}
