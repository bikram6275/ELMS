<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Survey\SurveyRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\Configurations\FiscalYearRepository;
use App\Models\Survey\Survey;
use App\Http\Requests\Survey\SurveyRequest;

class SurveyController extends Controller
{

    /**
     * @var SurveyRepository
     */
    private $surveyRepository;
    /**
     * @var Survey
     */
    private $survey;
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;
    /**
     * @var FiscalYearRepository
     */
    private $fiscalYearRepository;

    public function __construct(SurveyRepository $surveyRepository , Survey $survey, OrganizationRepository $organizationRepository, FiscalYearRepository $fiscalYearRepository)
    {


        $this->surveyRepository = $surveyRepository;
        $this->survey = $survey;
        $this->organizationRepository = $organizationRepository;
        $this->fiscalYearRepository = $fiscalYearRepository;
    }

    public function index()
    {
        $surveys=$this->surveyRepository->all();
        $fiscalyears=$this->fiscalYearRepository->all();
        return view('backend.survey.index',compact('surveys','fiscalyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveys=$this->surveyRepository->all();
        $fiscalyears=$this->fiscalYearRepository->all();
        return view('backend.survey.create',compact('surveys','fiscalyears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyRequest $request)
    {
        try {
            $create = $this->survey->create($request->all());
            if ($create) {
                session()->flash('success', 'Survey successfully added');
                return redirect(route('survey.index'));

            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('survey.index'));
            }

        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('survey.index'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request,$id)
    {
        try {
            $id = (int)$id;
            $edits = $this->surveyRepository->findById($id);
            if ($edits->count() > 0) {

                $organizations=$this->organizationRepository->all($request);
                $fiscalyears=$this->fiscalYearRepository->all();
                $surveys=$this->surveyRepository->all();
                return view('backend.survey.edit', compact('edits','organizations','fiscalyears','surveys'));
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
    public function update(SurveyRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $survey = $this->surveyRepository->findById($id);
            if ($survey) {
                $survey->fill($request->all())->save();
                session()->flash('success', 'Survey updated successfully!');

                return redirect(route('survey.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
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
        $id = (int)$id;
        try {
            $value = $this->surveyRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Survey successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function status($id){
        try {
            $id = (int)$id;

            $survey = $this->surveyRepository->findById($id);
            if ($survey->survey_status == 'inactive') {
                $survey->survey_status = 'active';
                $survey->save();
                session()->flash('success', 'Survey Successfully Activated!');
                return back();
            }
            $survey->survey_status = 'inactive';
            $survey->save();
            session()->flash('success', 'Survey Successfully Deactivated!');
            return back();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return back();
        }

    }
}
