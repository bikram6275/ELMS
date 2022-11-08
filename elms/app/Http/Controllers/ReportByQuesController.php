<?php

namespace App\Http\Controllers;

use App\Models\Configuration\Pradesh;
use App\Models\Configuration\ProductAndServices;
use App\Models\QuestionOptions;
use App\Repository\AnswerRepository;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\MunicipalityRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\DataRepository;
use App\Repository\Occupation\OccupationRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\QuestionOptionsRepository;
use App\Repository\QuestionRepository;
use App\Repository\Survey\SurveyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportByQuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $districtRepository;
    private $municipalityRepository;
    private $pradeshRepository;
    private $surveyRepository;
    private $questionRepository;
    private $answerRepository;
    private $organizationRepository;
    private $questionOptionsRepository;
    private $dataRepository;


    private $occupationRepository;

    public function __construct(
        DistrictRepository $districtRepository,
        MunicipalityRepository $municipalityRepository,
        PradeshRepository $pradeshRepository,
        SurveyRepository $surveyRepository,
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        OrganizationRepository $organizationRepository,
        QuestionOptionsRepository $questionOptionsRepository,
        DataRepository $dataRepository,
        OccupationRepository  $occupationRepository
    ) {
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->municipalityRepository = $municipalityRepository;
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->organizationRepository = $organizationRepository;
        $this->questionOptionsRepository = $questionOptionsRepository;
        $this->dataRepository = $dataRepository;
        $this->occupationRepository = $occupationRepository;
    }
    public function index(Request $request)
    {
        $organizations = null;
        $countby = null;
        $optionname = null;
        $question_options = null;
        $skills = null;
        $childquestion = null;
        $occupation = null;
        $humanresources = null;
        $quartile = [];
        $occupationsdetails = array();
        $organ = [];

        $ansType = $this->dataRepository->ansType();
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        $municipalities = $this->municipalityRepository->all();
        $surveys = $this->surveyRepository->getSurvey();
        $surveysQues = $this->surveyRepository->findById($request->survey_id);
        $questions = $this->questionRepository->parentQuestion();
        $questionfind = $this->questionRepository->findById($request->question_id);

        if ($questionfind != null && $questionfind->ans_type == "radio") {
            $organizations = $this->organizationRepository->filterradio($request);
        } else if ($questionfind != null && $questionfind->ans_type == "cond_radio") {
            $organizations = $this->organizationRepository->filterconditionalRadio($request, $questionfind->qsn_number);
            if($questionfind->qsn_number == '8'){

                $occupationsdetails = $organizations['occupations_details'];
                $organizations = $organizations['condi_radio'];
                $occupations = $this->occupationRepository->all();
                $occupation = $occupations->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['occupation_name']];
                });
            }
        } else if (($questionfind != null && $questionfind->ans_type == "checkbox") || ($questionfind != null && $questionfind->ans_type == "services")) {
            $organizations1 = $this->organizationRepository->filtercheckbox($request);
            $split = [];
            foreach ($organizations1 as $value) {
                $name = $value->answer;
                $split[] = explode(",", $name);
            }
            $temp = [];
          
            for ($i = 0; $i <= count($split) - 1; $i++) {
                $temp = array_merge($temp, $split[$i]);
            }
            $total_response =  $organizations1->count();
            $countby = collect($temp)->countBy();
           
            if ($questionfind->ans_type == "checkbox") {
                $option = QuestionOptions::where('qsn_id', $request->question_id)->get();

                $optionname = $option->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['option_name']];
                });
                $organizations = [];
                
                foreach ($countby as $key => $value) {
                    $organizations2['count'] = $value;
                    $organizations2['option_name'] = $optionname[$key];
                    $organizations2['total_response']= $total_response;
                    array_push($organizations, $organizations2);
                }
                
            } elseif ($questionfind->ans_type == "services") {
                $option = ProductAndServices::orderBy('id', 'desc')->get();

                $optionname = $option->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['product_and_services_name']];
                });
                
                $organizations = [];
                foreach ($countby as $key => $value) {
                    $organizations2['count'] = $value;
                    $organizations2['option_name'] = $optionname[$key];
                    $organizations2['total_response']= $total_response;
                    array_push($organizations, $organizations2);
                }
            }
        } else if ($questionfind != null && $questionfind->ans_type == "input") {
            $organizations = $this->organizationRepository->filterinput($request);
        } else if ($questionfind != null && $questionfind->ans_type == "multiple_input") {
            $organizations1 = $this->organizationRepository->filtermultipleinput($request);

            $split = [];
            foreach ($organizations1 as $value) {
                $name = json_decode($value->answer);
                $split[] = $name;
            }
            $temp = [];

            foreach ($split as $k => $subArray) {
                foreach ($subArray as $id => $value) {
                    if (array_key_exists($id, $temp)) {
                        $temp[$id] += (int)$value;
                    } else {
                        $temp[$id] = (int)$value;
                    }
                }
            }
            $countby = $temp;
            $question_options = $this->questionOptionsRepository->findByQsnId($request->question_id);

            $optionname = $question_options->mapWithKeys(function ($item) {
                return [$item['id'] => $item['option_name']];
            });
            $organizations = [];
            foreach ($countby as $key => $value) {
                $organizations2['count'] = $value;
                $organizations2['option_name'] = $optionname[$key];
                array_push($organizations, $organizations2);
            }
        } elseif ($questionfind != null &&  $questionfind->qsn_number == '13') {
            $organizations1 = $this->organizationRepository->filterexternal_table($request, $questionfind->qsn_number);

            $organizations = [];
            foreach ($organizations1 as $key => $value) {
                if (!empty($key)) {
                    $organizations[$key] = [];
                    $organizations[$key]['formally_trained'] = 0;
                    $organizations[$key]['formally_untrained'] = 0;
                    foreach ($value as $k => $v) {
                        $organizations[$key]['formally_trained'] += $v->formally_trained;
                        $organizations[$key]['formally_untrained'] += $v->formally_untrained;
                    }
                }
            }
            $skills = $this->dataRepository->skills();
        } elseif ($questionfind != null && $questionfind->ans_type == "sector") {
            $organizations = $this->organizationRepository->filtersector($request);
        } elseif ($questionfind != null && $questionfind->ans_type == "sub_qsn") {

            $childquestion = $this->questionRepository->findchild($request->question_id);
            $organizations1 = $this->organizationRepository->filtersubqsn($request, $childquestion);
            $organizations = [];
            foreach ($organizations1 as $key => $value) {
                $organizations[$key] = 0;
                foreach ($value as $k => $v) {
                    $status = false;
                    $answer = json_decode($v->answer);
                    foreach ($answer as $key1 => $value1) {
                        if ($value1 != null) {
                            $status = true;
                        }
                    }
                    if ($status == true) {
                        $organizations[$key]++;
                    }
                }
               
            }
            // return $organizations;
        } elseif ($questionfind != null && $questionfind->qsn_number == "6.b") {
            $organizations = $this->organizationRepository->filterexternal_table($request, $questionfind->qsn_number);
            $organ = $this->organizationRepository->getEmpStatusData($request, $questionfind->qsn_number);
            $occupations = $this->occupationRepository->all();
            $occupation = $occupations->mapWithKeys(function ($item) {
                return [$item['id'] => $item['occupation_name']];
            });
        } elseif ($questionfind != null && ($questionfind->qsn_number == "5.1" || $questionfind->qsn_number == "5.2" || $questionfind->qsn_number == "5.3")) {
            
            $organizations = $this->organizationRepository->filterexternal_table($request, $questionfind->qsn_number);
            $quartile = $this->organizationRepository->getHumanResourceData($request, $questionfind->qsn_number);
            $humanresources = $this->dataRepository->humanResource();
        }
        return view('backend.report.reportbyques', compact('organ','quartile','pradeshes', 'districts', 'municipalities', 'surveys', 'questions', 'ansType', 'organizations', 'questionfind', 'countby', 'optionname', 'surveysQues', 'question_options', 'skills', 'childquestion', 'occupation', 'humanresources', 'occupationsdetails'));
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
}
