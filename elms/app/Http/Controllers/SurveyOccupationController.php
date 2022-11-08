<?php

namespace App\Http\Controllers;

use App\Models\SurveyOrgOccupation;
use App\Repository\Occupation\OccupationRepository;
use App\Repository\Survey\SurveyRepository;
use App\Repository\SurveyOrgOccupationRepository;
use Illuminate\Http\Request;

class SurveyOccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $surveyRepository;
    private $occupationRepository;
    private $surveyOrgOccupationRepository;

    public function __construct(
        SurveyRepository $surveyRepository,
        OccupationRepository $occupationRepository,
        SurveyOrgOccupationRepository $surveyOrgOccupationRepository
    ) {
        $this->surveyRepository = $surveyRepository;
        $this->occupationRepository = $occupationRepository;
        $this->surveyOrgOccupationRepository = $surveyOrgOccupationRepository;
    }
    public function index(Request $request)
    {
        $surveys = $this->surveyRepository->all();
        $status = false;
        $survey_occupation = '';
        $survey_id = $request->survey_id;
        if ($survey_id != null) {
            $status = true;
            $result = $this->surveyOrgOccupationRepository->findBySurvey($request->survey_id);
            $survey_occupation = $result->mapWithKeys(function ($item) {
                return [$item['id'] => $item['occupation_id']];
            })->toArray();
        }
        $occupations = $this->occupationRepository->all();

        return view('backend.survey_occupation.add', compact('surveys', 'occupations', 'status', 'survey_id','survey_occupation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
            $occupations_details = $request->all();
            $oldData = $this->surveyOrgOccupationRepository->findBySurvey($request->survey_id);
            if ($oldData != null) {
                foreach ($oldData as $old_data) {
                    $old_data->delete();
                }
            }
            foreach ($occupations_details['occupation_id'] as $val) {
                $data['survey_id'] = $request->survey_id;
                $data['occupation_id'] = $val;

                $create = SurveyOrgOccupation::create($data);
            }
            if ($create) {
                session()->flash('success', 'Survey Occupation successfully created!');
                return redirect(route('survey_occupation.index'));
            } else {
                session()->flash('error', 'Question could not be created!');
                return redirect(route('survey_occupation.index'));
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
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
