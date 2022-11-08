<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\CoordinatorSupervisorRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use App\Repository\Report\EnumeratorReportRepository;
use App\Repository\Survey\SurveyRepository;
use Illuminate\Http\Request;

class EnumeratorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $enumeratorRepository;
    private $enumeratorassignRepository;

    public function __construct(EnumeratorReportRepository $enumeratorRepository, EnumeratorAssignRepository $enumeratorassignRepository,
        PradeshRepository $pradeshRepository, DistrictRepository $districtRepository, SurveyRepository $surveyRepository,
        EnumeratorAssignRepository $enumeratorAssignRepository, CoordinatorSupervisorRepository $coordinatorSupervisorRepository
    )
    {

        $this->enumeratorRepository = $enumeratorRepository;
        $this->enumeratorassignRepository = $enumeratorassignRepository;
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->surveyRepository = $surveyRepository;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
        $this->coordinatorSupervisorRepository = $coordinatorSupervisorRepository;
    }
    public function index(Request $request)
    {

        $surveys = $this->enumeratorRepository->all();

        $enumeratorassigns = $this->enumeratorassignRepository->all($request);
        return view('backend.report.index', compact('surveys', 'enumeratorassigns'));
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view(Request $request)
    {
        $enum = EnumeratorAssign::with('survey')->get();
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        $status = $this->surveyRepository->surveyStatus($request);
        $completeList= $this->enumeratorAssignRepository->completeSurvey($request);
        $coordinatorSurvey = $this->coordinatorSupervisorRepository->coordinatorsurvey($request);

        // $test = EnumeratorAssign::where('status','unsupervised')->whereHas('organization',function($query){
        //     $query = $query->where('district_id',38);
        // })->get();
        // return $test;
        // return view('test',compact('test'));
        return view('backend.report.survey_status',compact('pradeshes','districts','status','completeList','coordinatorSurvey'));
    }
}
