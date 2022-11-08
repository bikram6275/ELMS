<?php

namespace App\Http\Controllers\Emitter\Emitter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Survey\SurveyRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class SurveyController extends Controller
{
    /**
     * @var SurveyRepository
     */
    private $surveyRepository;
    /**
     * @var EnumeratorAssignRepository
     */
    private $enumeratorAssignRepository;

    public function __construct(SurveyRepository $surveyRepository , EnumeratorAssignRepository $enumeratorAssignRepository)
    {


        $this->surveyRepository = $surveyRepository;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
    }

    public function index()
    {
        $surveys=$this->surveyRepository->activeSurvey();
        return view('emitter.survey.index',compact('surveys'));

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
//        $assignedsurvey=$this->enumeratorAssignRepository->findById($id);
//        return view('emitter.survey.organization',compact('assignedsurvey'));
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


}
