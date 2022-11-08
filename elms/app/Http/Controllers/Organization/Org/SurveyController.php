<?php

namespace App\Http\Controllers\Organization\Org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Survey\SurveyRepository;


class SurveyController extends Controller
{

    /**
     * @var SurveyRepository
     */
    private $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository )
    {


        $this->surveyRepository = $surveyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys=$this->surveyRepository->activeSurvey();
        return view('organization.survey.index',compact('surveys'));


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
        $surveys=$this->surveyRepository->all();
        return view('organization.survey.index',compact('surveys'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey=$this->surveyRepository->findById($id);
        return view('organization.survey.show',compact('survey'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
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

    public function answer($id){
        return view('organization.survey.answer');
    }

}
