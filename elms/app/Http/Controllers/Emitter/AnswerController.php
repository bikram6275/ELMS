<?php

namespace App\Http\Controllers\Emitter;

use DB;
use Carbon\Carbon;
use App\Models\Answers;
use App\Models\Questions;
use App\Models\FeedbackLog;
use App\Models\WorkerSkills;
use Illuminate\Http\Request;
use App\Models\HumanResources;
use App\Models\SurveyEmpStatus;
use App\Models\TechnologyDetails;
use App\Models\BusinessFuturePlan;
use App\Repository\DataRepository;
use App\Http\Controllers\Controller;
use App\Repository\AnswerRepository;
use App\Models\OtherOccupationDetails;
use App\Repository\QuestionRepository;
use App\Models\TechnicalHumanResources;
use App\Repository\QuestionOptionsRepository;
use App\Repository\SurveyOrgOccupationRepository;
use App\Repository\Occupation\OccupationRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\Configurations\ProductAndServiceRepository;
use App\Repository\Education\EducationQualificationRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $questionRepository;
    private $questionOptionsRepository;
    private $organizationRepository;
    private $economicSectorRepository;
    private $dataRepository;
    private $eduQualificationRepository;
    private $answerRepository;
    private $surveyOrgOccupationRepository;
    private $enumeratorAssignRepository;
    private $productAndServiceRepository;
    private $occupationRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        QuestionOptionsRepository $questionOptionsRepository,
        OrganizationRepository $organizationRepository,
        EconomicSectorRepository $economicSectorRepository,
        DataRepository $dataRepository,
        EducationQualificationRepository $eduQualificationRepository,
        AnswerRepository $answerRepository,
        SurveyOrgOccupationRepository $surveyOrgOccupationRepository,
        EnumeratorAssignRepository $enumeratorAssignRepository,
        ProductAndServiceRepository $productAndServiceRepository,
        OccupationRepository $occupationRepository

    ) {
        $this->questionRepository = $questionRepository;
        $this->questionOptionsRepository = $questionOptionsRepository;
        $this->organizationRepository = $organizationRepository;
        $this->economicSectorRepository = $economicSectorRepository;
        $this->dataRepository = $dataRepository;
        $this->eduQualificationRepository = $eduQualificationRepository;
        $this->answerRepository = $answerRepository;
        $this->surveyOrgOccupationRepository = $surveyOrgOccupationRepository;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
        $this->productAndServiceRepository = $productAndServiceRepository;
        $this->occupationRepository = $occupationRepository;
    }

    public function index($pivot_id)
    {
        $questions = $this->checkAnsStatus($pivot_id);
        $first_page = true;
        $assignedOrg = $this->enumeratorAssignRepository->findById($pivot_id);
        $assignedorgId = $assignedOrg->organization_id;
        $org_details = $this->organizationRepository->findById($assignedorgId);
        return view('emitter.answer.add', compact('questions', 'first_page', 'org_details', 'pivot_id'));
    }

    public function listQuestion($pivot_id, $qsn_id)
    {

        $recent_questions = $this->questionRepository->recentQuestion($qsn_id);
        $questions = $this->checkAnsStatus($pivot_id);
        $first_page = false;
        $assignedOrg = $this->enumeratorAssignRepository->findById($pivot_id);
        $survey_id = $assignedOrg->survey_id;
        $assignedorgId = $assignedOrg->organization_id;
        $org_details = $this->organizationRepository->findById($assignedorgId);
        $sectors = $this->economicSectorRepository->economicSectorFilter($org_details->sector_id);
        $total_technical = HumanResources::where('enumerator_assign_id',$pivot_id)->where('working_type','technical')->sum('total');


        $other_answer = '';
        $answer = '';
        $humanResources = '';
        $occupations = '';
        $workers = '';
        $educations = '';
        $skills = '';
        $subSectorSector = '';
        $parentSector = '';
        $serviceList = '';

        if ($qsn_id == 0) {
            $first_page = true;
        }
        if ($recent_questions->count() > 0) {

            if ($recent_questions->qsn_number == 5.1) {

                $humanResources = $this->dataRepository->humanResource();
                $workers = $this->dataRepository->workers();
                $answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'employer')->get()->groupBy(['working_type']);
                // return $answer;
            } elseif ($recent_questions->qsn_number == '5.2') {
                $humanResources = $this->dataRepository->humanResource();
                $workers = $this->dataRepository->workers();
                $answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'family_member')->get()->groupBy(['working_type']);
            } elseif ($recent_questions->qsn_number == '5.3') {
                $humanResources = $this->dataRepository->humanResource();
                $workers = $this->dataRepository->workers();
                $answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'employees')->get()->groupBy(['working_type']);
            } elseif ($recent_questions->qsn_number == '6.a') {
                $occupations = $this->occupationRepository->sectorWiseOccupation($org_details->sector_id);
                $educations = $this->eduQualificationRepository->educations();
                $answer = TechnicalHumanResources::with('generalEducation','tvetEducation')->where('enumerator_assign_id', $pivot_id)->get();
            } elseif ($recent_questions->qsn_number == '6.b') {

                $occupations = $this->surveyOrgOccupationRepository->orgOccupation($survey_id, $org_details->sector_id);
                $answer = SurveyEmpStatus::where('enumerator_assign_id', $pivot_id)->get()->groupBy('occupation_id');
            } elseif ($recent_questions->qsn_number == 9) {

                $child = $this->questionRepository->findchild($recent_questions->id)[0];
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
                $other_answer = $this->answerRepository->findByQsnId($child->id, $pivot_id);
            } elseif ($recent_questions->qsn_number == 8) {
                $occupations = $this->occupationRepository->sectorWiseOccupation($org_details->sector_id);
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
                $other_answer = OtherOccupationDetails::where('enumerator_assign_id', $pivot_id)->get();
            } elseif ($recent_questions->qsn_number == 13) {
                $skills = $this->dataRepository->skills();
                $answer = WorkerSkills::where('enumerator_assign_id', $pivot_id)->get()->groupBy('skill');
            } elseif ($recent_questions->qsn_number == 17) {
                $parentSector = $this->economicSectorRepository->parents();
                $subSectorSector = $this->economicSectorRepository->subSectorList();
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
                $other_answer = TechnologyDetails::with('sector')->where('enumerator_assign_id', $pivot_id)->first();
            } elseif ($recent_questions->qsn_number == 18) {
                $occupations = $this->occupationRepository->getOccupation();
                $parentSector = $this->economicSectorRepository->parents();
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
                $other_answer = BusinessFuturePlan::where('enumerator_assign_id', $pivot_id)->get();
            } elseif ($recent_questions->qsn_number == 4) {

                $sub_sector = $this->answerRepository->findByQsnId(14, $pivot_id);
                if ($sub_sector != null) {
                    $sub_sector_id = $sub_sector->answer;
                    $serviceList = $this->productAndServiceRepository->findBySecor($sub_sector_id);
                }
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
            } elseif ($recent_questions->ans_type == 'sub_qsn') {

                $childrens = $this->questionRepository->findchild($recent_questions->id);
                $answer = [];
                foreach ($childrens as $val) {
                    $answer[$val->id] = $this->answerRepository->findByQsnId($val->id, $pivot_id);
                }
            } else {
                $answer = $this->answerRepository->findByQsnId($qsn_id, $pivot_id);
            }
        }
        // return $recent_questions; 
        // return $answer;
        return view('emitter.answer.add', compact('total_technical','questions', 'sectors', 'humanResources', 'workers', 'occupations', 'educations', 'first_page', 'recent_questions', 'answer', 'other_answer', 'pivot_id', 'org_details', 'skills', 'parentSector', 'subSectorSector', 'serviceList'));
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
      
        $surveyDetails = $request->all();
        $question = $this->questionRepository->findById($surveyDetails['qsn_id']);
        $qsn_order = $this->getQsnList($surveyDetails['qsn_id']);
        $next_qsn_id = $qsn_order->next_qst_id;
        $current_date = Carbon::now()->format('Y-m-d');
        $assignedOrg = $this->enumeratorAssignRepository->findById($request->pivot_id);

        if ($assignedOrg->start_date == null) {
            $data['start_date'] = $current_date;
            $assignedOrg->fill($data)->save();
        }
        if ($next_qsn_id == 0) {
            $data['finish_date'] = $current_date;
            $assignedOrg->fill($data)->save();
        }


        if ($question) {
            switch ($question->ans_type) {
                case 'input':
                    $this->saveInputData($request);
                    break;

                case 'radio':
                    $this->saveRadioData($request);
                    break;

                case 'checkbox':
                    $this->saveCheckboxData($request);
                    break;

                case 'services':
                    // return $request;
                    $this->saveCheckboxData($request);
                    break;

                case 'sector':
                    $this->saveInputData($request);
                    break;

                case 'multiple_input':
                    $this->saveMultipleInputData($request);
                    break;

                case 'range':
                    $this->saveMultipleInputData($request);
                    break;

                case 'cond_radio':

                    switch ($question->qsn_number) {

                        case '8':
                            $this->saveQuestionNo8($request);
                            break;

                        case '9':
                            $this->saveQuestionNo9($request);
                            break;

                        case '17':
                            $this->saveQuestionNo17($request);
                            break;
                        case '18':
                            $this->saveQuestionNo18($request);
                            break;
                    }

                case 'external_table':
                    switch ($question->qsn_number) {

                        case '5.1':
                            $request['resource_type'] = "employer";
                            $this->saveHumanResourceData($request);
                            break;
                        case '5.2':
                            $request['resource_type'] = "family_member";
                            $this->saveHumanResourceData($request);
                            break;
                        case '5.3':
                            $request['resource_type'] = "employees";
                            $this->saveHumanResourceData($request);
                            break;

                        case '6.a':
                            $this->saveTechnicalHumanResourceData($request);
                            break;

                        case '6.b':
                            $this->saveEmployeeStatusData($request);
                            break;

                        case '13':
                            $this->saveQuestionNo13($request);
                            break;
                    }
                case 'sub_qsn':
                    switch ($question->qsn_number) {
                        case '2':
                            $this->saveQuestionNo2($request);
                            break;
                    }
            }
            if ($next_qsn_id == '6' || $next_qsn_id == '7' || $next_qsn_id == '38' || $next_qsn_id == '5') {
                $next_qsn_id = $this->checkMembershipStatus($request->pivot_id, $next_qsn_id);
            }
            if ($next_qsn_id == '40' || $next_qsn_id == '41' || $next_qsn_id == '42') {
                $next_qsn_id = $this->checkQuestion5Status($request->pivot_id, $next_qsn_id);
            }

            if ($next_qsn_id == 0) {
                session()->flash('success', 'Answers saved successfully!');

                return redirect('emitters/dashboard');
            } else {
                session()->flash('success', 'Answers saved successfully!');

                return redirect("emitters/survey/orgs/question/$request->pivot_id/$next_qsn_id");
            }
        }
    }

    public function saveInputData($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $data['answer'] = $request->answer;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }
    public function saveRadioData($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $data['qsn_opt_id'] = $request->answer;
            $data['other_answer'] = isset($request->other_answer) ? $request->other_answer : null;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }


    public function saveCheckboxData($request)
    {
        try {

            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            if ($request->answer != null) {
                $data['answer'] = implode(',', $request->answer);
            } else {
                $data['answer'] = null;
            }
            $data['other_answer'] = isset($request->other_answer) ? $request->other_answer : null;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }
    public function saveMultipleInputData($request)
    {
   
        try {

            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $data['answer'] = json_encode($request->answer);

            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }
    public function saveQuestionNo2($request)
    {
        try {

            $data['enumerator_assign_id'] = $request->pivot_id;
            foreach ($request->answer as $qsn_id => $ans) {
                $data['qsn_id'] = $qsn_id;
                $data['answer'] = json_encode($ans['data']);
                $result = Answers::updateOrCreate(['id' => isset($ans['id']) ? $ans['id'] : 0], $data);
            }
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function saveHumanResourceData($request)
    {
        try {

            foreach ($request['human_resource'] as $res_key => $working) {
                if ($working['male_count'] != null) {
                    $working['enumerator_assign_id'] = $request->pivot_id;
                    $working['resource_type'] = $request['resource_type'];
                    $working['working_type'] = $res_key;
                    $working['total'] = $working['nepali_count'] + $working['foreigner_count'] + $working['neighboring_count'];
                    $result = HumanResources::updateOrCreate(['id' => $working['id']], $working);
                }
            }
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function saveTechnicalHumanResourceData($request)

    {
        $request->validate([
            'technical.*.gender' => 'required',
            'technical.*.occupation_id' => 'required',
            'technical.*.working_time' => 'required',
            'technical.*.work_nature' => 'required',
            'technical.*.training' => 'required',
            'technical.*.edu_qua_general' => 'required',
            'technical.*.edu_qua_tvet' => 'required',
            'technical.*.ojt_apprentice' => 'required',
        ]);

        try {
            foreach ($request['technical'] as $key => $technical) {
                
                $technical['enumerator_assign_id'] = $request->pivot_id;
                if($technical['occupation_id'] != 279){
                    $technical['other_occupation_value'] = null;
                }
                $result = TechnicalHumanResources::updateOrCreate(['id' => isset($technical['id']) ? $technical['id'] : 0], $technical);
            }
            return $result;
        } catch (\Exception $e) {
            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function saveQuestionNo13($request)
    {
        $request->validate([
            'skill.*.formally_trained' => 'required|numeric|min:1|max:5',
            'skill.*.formally_untrained' => 'required|numeric|min:1|max:5',
        ]);
        try {
            foreach ($request['skill'] as $key => $skill) {

                $skill['enumerator_assign_id'] = $request->pivot_id;
                $skill['skill'] = $key;
                $result = WorkerSkills::updateOrCreate(['id' => isset($skill['id']) ? $skill['id'] : 0], $skill);
            }
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function saveQuestionNo8($request)
    {
        $data['qsn_opt_id'] = $request->answer;
        $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);
        if ($options->option_name == 'Yes') {
            $request->validate([
                'occu.*.occupation_id' => 'required',
                'occu.*.present_demand' => 'required|numeric',
                'occu.*.demand_two_year' => 'required|numeric',
                'occu.*.demand_five_year' => 'required|numeric',
            ]);
        }
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;

            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            if ($options->option_name == 'Yes') {
                foreach ($request['occu'] as $occupation) {
                    if($occupation['occupation_id'] != 279)
                    {
                        
                       $occupation['other_value'] = null; 
                    }
                    $occupation['enumerator_assign_id'] = $request->pivot_id;
                    OtherOccupationDetails::updateOrCreate(['id' => isset($occupation['id']) ? $occupation['id'] : 0], $occupation);
                }
            } else {
                OtherOccupationDetails::where('enumerator_assign_id', $request->pivot_id)->delete();
            }
            return $result;
        } catch (\Exception $e) {
            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function saveQuestionNo9($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $data['qsn_opt_id'] = $request->answer;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);

            if ($options->option_name == 'No') {
                foreach ($request->optionalAnswer as $opt_key => $val) {
                    $sub_qsn['enumerator_assign_id'] = $request->pivot_id;
                    $sub_qsn['qsn_id'] = $opt_key;
                    $sub_qsn['answer'] = $val;
                    $result = Answers::updateOrCreate(['id' => isset($request->sub_qsn_id) ? $request->sub_qsn_id : 0], $sub_qsn);
                }
            } else {
                $child = $this->questionRepository->findchild($request->qsn_id);
                Answers::where('qsn_id', $child[0]->id)->delete();
            }
            return $result;
        } catch (\Exception $e) {
            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }
    public function saveQuestionNo17($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $data['qsn_opt_id'] = $request->answer;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);
            $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);

            if ($options->option_name == 'Yes') {

                $technology_details = $request->technology;
                $technology_details['enumerator_assign_id'] = $request->pivot_id;
                TechnologyDetails::updateOrCreate(['id' => isset($technology_details['id']) ? $technology_details['id'] : 0], $technology_details);
            } else {
                TechnologyDetails::where('enumerator_assign_id', $request->pivot_id)->delete();
            }

            return $result;
        } catch (\Exception $e) {
            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }
    public function saveQuestionNo18($request)
    {
        // dd($request);

        $data['qsn_opt_id'] = $request->answer;
        $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);
        if ($options->option_name == 'Yes') {
            $request->validate([
                'skill.*.occupation' => 'required',
                'skill.*.sector' => 'required',
                'skill.*.level' => 'required',
                'skill.*.required_number' => 'required|numeric',
                'skill.*.incorporate_possible' => 'required',
            ]);
        }
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->qsn_id;
            $result = Answers::updateOrCreate(['id' => $request->id], $data);

            if ($options->option_name == 'Yes') {

                $skilled_details = $request->skilled;
                foreach ($skilled_details as $key=>$skill) {
                    if(!isset($skill['other_occupation_value'])){
                        $skill['other_occupation_value'] = null;
                    }
                    $skill['enumerator_assign_id'] = $request->pivot_id;
                    BusinessFuturePlan::updateOrCreate(['id' => isset($skill['id']) ? $skill['id'] : 0], $skill);
                }
            } else {
                BusinessFuturePlan::where('enumerator_assign_id', $request->pivot_id)->delete();
            }
            return $result;
        } catch (\Exception $e) {
            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }



    public function otherOccupationDelete($id)
    {
        $id = (int)$id;
        try {
            OtherOccupationDetails::where('id', $id)->first()->delete();
            session()->flash('success', 'Option successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
    public function technicalHumanDelete($id)
    {
        $id = (int)$id;
        try {
            TechnicalHumanResources::where('id', $id)->first()->delete();
            session()->flash('success', 'Option successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
    public function businessPlanDelete($id)
    {
        $id = (int)$id;
        try {
            BusinessFuturePlan::where('id', $id)->first()->delete();
            session()->flash('success', 'Option successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
    public function saveEmployeeStatusData($request)
    {
        $request->validate([
            'occupation_status.*.working_number' => 'required|numeric|min:0',
            'occupation_status.*.required_number' => 'required|numeric|min:0',
            'occupation_status.*.for_two_years' => 'required|numeric|min:0',
            'occupation_status.*.for_five_years' => 'required|numeric|min:0',
        ]);
        try {
            foreach ($request['occupation_status'] as $occ_key => $occupation) {
                $occupation['enumerator_assign_id'] = $request->pivot_id;
                $occupation['occupation_id'] = $occ_key;

                $result = SurveyEmpStatus::updateOrCreate(['id' => isset($occupation['id']) ? $occupation['id'] : 0], $occupation);
            }
            return $result;
        } catch (\Exception $e) {

            session()->flash('error', 'EXCEPTION:' . $e->getMessage());
            return back()->withInput();
        }
    }

    public static function getQsnList($qsn_id)
    {
        $qsn = DB::select("call getNextPrevQst(" . $qsn_id . ")");
        return $qsn[0];
    }


    public function viewAnswer($pivot_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->findById($pivot_id);
        $assignedorgId = $assignedOrganization->organization_id;
        $org_details = $this->organizationRepository->findById($assignedorgId);
        $questions = $this->questionRepository->questionsWithAnswer($pivot_id);
        $sectors = $this->economicSectorRepository->all();
        $allsectors = $sectors->mapWithKeys(function ($value) {
            return [$value['id'] => $value['sector_name']];
        });
        $answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','employer')->get()->groupBy(['working_type']);
        
        $family_answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','family_member')->get()->groupBy([ 'working_type']);
        $employee_answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','employees')->get()->groupBy(['working_type']);

        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        $technicalAnswer = TechnicalHumanResources::with('generalEducation', 'tvetEducation','sector', 'occupation')->where('enumerator_assign_id', $pivot_id)->get();
        $occupations = $this->surveyOrgOccupationRepository->orgOccupation($assignedOrganization->survey_id, $assignedOrganization->organization->sector_id);
        $empStatusAnswer = SurveyEmpStatus::where('enumerator_assign_id', $pivot_id)->get()->groupBy('occupation_id');
        $othter_occupationAnswer = OtherOccupationDetails::where('enumerator_assign_id', $pivot_id)->get();
        $skills = $this->dataRepository->skills();
        $skillAnswer = WorkerSkills::where('enumerator_assign_id', $pivot_id)->get()->groupBy('skill');
        $technology_details = TechnologyDetails::with('sector')->where('enumerator_assign_id', $pivot_id)->first();
        $business_plans = BusinessFuturePlan::where('enumerator_assign_id', $pivot_id)->get();
        $sub_sector = $this->answerRepository->findByQsnId(14, $pivot_id);
        $services = '';
        if ($sub_sector != null) {
            $sub_sector_id = $sub_sector->answer;
            $serviceList = $this->productAndServiceRepository->findBySecor($sub_sector_id);
            $services = $serviceList->mapWithKeys(function ($value) {
                return [$value['id'] => $value['product_and_services_name']];
            });
        }
        $feedbacks = FeedbackLog::where('enumerator_assign_id',$pivot_id)->get();

        return view('emitter.answer.show', compact('feedbacks','employee_answer','family_answer','assignedOrganization', 'org_details', 'questions', 'sectors', 'humanResources', 'answer', 'workers', 'technicalAnswer', 'occupations', 'empStatusAnswer', 'othter_occupationAnswer', 'skills', 'skillAnswer', 'technology_details', 'allsectors', 'business_plans', 'services'));
    }

    public function respondentInfo(Request $request)
    {
        try {
            $details = $request->all();
            $data = $this->enumeratorAssignRepository->findById($request->id);
            $data->fill($details)->save();
            return redirect("emitters/survey/orgs/$request->id");
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function checkAnsStatus($pivot_id)
    {
        $questions = $this->questionRepository->questions();
        foreach ($questions as $qsn) {
            if ($qsn->qsn_number == 5.1) {
                $human_resource = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'employer')->get();
                if ($human_resource->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->qsn_number == '5.2') {

                $human_resource = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'employer')->get();
                if ($human_resource->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->qsn_number == '5.3') {

                $human_resource = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type', 'employer')->get();
                if ($human_resource->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->qsn_number == '6.a') {

                $technical = TechnicalHumanResources::with('generalEducation','tvetEducation')->where('enumerator_assign_id', $pivot_id)->get();
                if ($technical->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->qsn_number == '6.b') {

                $emp_status = SurveyEmpStatus::where('enumerator_assign_id', $pivot_id)->get()->groupBy('occupation_id');
                if ($emp_status->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->qsn_number == '13') {

                $worker_skill = WorkerSkills::where('enumerator_assign_id', $pivot_id)->get()->groupBy('skill');
                if ($worker_skill->count() > 0) {
                    $qsn['is_answer'] = true;
                }
            } elseif ($qsn->ans_type == 'sub_qsn') {

                $childrens = $this->questionRepository->findchild($qsn->id);
                foreach ($childrens as $val) {
                    $data = $this->answerRepository->findByQsnId($val->id, $pivot_id);
                    if ($data != null) {
                        $qsn['is_answer'] = true;
                    }
                }
            } else {
                $data1 = $this->answerRepository->findByQsnId($qsn->id, $pivot_id);
                if ($data1 != null) {
                    $qsn['is_answer'] = true;
                }
            }
        }
        return $questions;
    }

    public function checkMembershipStatus($pivot_id, $next_qsn_id)
    {
        $questionDetail = Questions::where('qsn_number', 2)->first();

        $childrens = $this->questionRepository->findchild($questionDetail->id);
        foreach ($childrens as $val) {
            $data = $this->answerRepository->findByQsnId($val->id, $pivot_id);
            if ($data != null) {
                $option = (array)json_decode($data->answer);
                $check_data[$val->qsn_name] = false;
                foreach ($option as $op) {
                    if ($op != null) {
                        $check_data[$val->qsn_name] = true;
                    }
                }
            }
        }
        if ($next_qsn_id == '6') {
            if ($check_data['FNCCI'] == true || $check_data['FNCSI'] == true || $check_data['CNI'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }
        if ($next_qsn_id == '7') {
            if ($check_data['FCAN'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }
        if ($next_qsn_id == '38') {
            if ($check_data['HAN'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }

        if ($next_qsn_id == '5') {
            $question4answer = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', '4')->first();
            if ($question4answer->qsn_opt_id != 7) {

                $next_qsn_id = $next_qsn_id;
            } else {
                // dd($next_qsn_id);

                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
                // dd($next_qsn_id);
            }
        }


        return $next_qsn_id;
    }

    public function checkQuestion5Status($pivot_id, $next_qsn_id)
    {
        $questionDetail = Questions::where('qsn_number', 5)->first();
        $check_data = [];
        $data = $this->answerRepository->findByQsnId($questionDetail->id, $pivot_id);
        if ($data != null) {
            $check_data['5.1'] = false;
            $check_data['5.2'] = false;
            $check_data['5.3'] = false;
            $options = explode(',', $data->answer);
            foreach ($options as $key => $option) {

                if ($option == '99') {
                    $check_data['5.1'] = true;
                } elseif ($option == '100') {
                    $check_data['5.2'] = true;
                } elseif ($option == '101') {
                    $check_data['5.3'] = true;
                }
            }
        }

        if ($next_qsn_id == '40') {
            if ($check_data['5.1'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }
        if ($next_qsn_id == '41') {
            if ($check_data['5.2'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }
        if ($next_qsn_id == '42') {
            if ($check_data['5.3'] == true) {
                $next_qsn_id = $next_qsn_id;
            } else {
                $qsn_order = $this->getQsnList($next_qsn_id);
                $next_qsn_id = $qsn_order->next_qst_id;
            }
        }

        return $next_qsn_id;
    }


    public static function checkMembershipPrevious($pivot_id, $qsn_id)
    {

        $questionDetail = Questions::where('qsn_number', 2)->first();

        $check_data = [];
        $childrens = Questions::where('parent_id', $questionDetail->id)->where('qst_status', 'active')->get();
        foreach ($childrens as $val) {
            $data = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', $val->id)->first();;
            if ($data != null) {
                $option = (array)json_decode($data->answer);
                $check_data[$val->qsn_name] = false;
                foreach ($option as $op) {
                    if ($op != null) {
                        $check_data[$val->qsn_name] = true;
                    }
                }
            }
        }
        if (count($check_data) > 0) {

            if ($qsn_id == '14') {

                if ($check_data['HAN'] == true) {
                    $check_id = Questions::where('qsn_number', '2.3')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['FCAN'] == true) {
                    $check_id = Questions::where('qsn_number', '2.2')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['FNCCI'] == true || $check_data['FNCSI'] == true || $check_data['CNI'] == true) {
                    $check_id = Questions::where('qsn_number', '2.1')->first()->id;
                    $qsn_order = $check_id;
                }
            }
            if ($qsn_id == '7') {
                if ($check_data['FNCCI'] == true || $check_data['FNCSI'] == true || $check_data['CNI'] == true) {
                    $check_id = Questions::where('qsn_number', '2.1')->first()->id;
                    $qsn_order = $check_id;
                } else {
                    $check_id = Questions::where('qsn_number', '2')->first()->id;
                    $qsn_order = $check_id;
                }
            }
            if ($qsn_id == '38') {

                if ($check_data['FCAN'] == true) {
                    $check_id = Questions::where('qsn_number', '2.2')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['FNCCI'] == true || $check_data['FNCSI'] == true || $check_data['CNI'] == true) {
                    $check_id = Questions::where('qsn_number', '2.1')->first()->id;
                    $qsn_order = $check_id;
                } else {
                    $check_id = Questions::where('qsn_number', '2')->first()->id;
                    $qsn_order = $check_id;
                }
            }
            if ($check_data['FNCCI'] == false &&  $check_data['FNCSI'] == false && $check_data['CNI'] == false && $check_data['FCAN'] == false && $check_data['HAN'] == false) {
                $check_id = Questions::where('qsn_number', '2')->first()->id;
                $qsn_order = $check_id;
            }
            if ($qsn_id == '8') {
                $question4answer = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', '4')->first();
                if ($question4answer->qsn_opt_id == '7') {
                    $check_id = 4;
                    $qsn_order = $check_id;
                } else {
                    $check_id = 5;
                    $qsn_order = $check_id;
                }
            }
        } else {
            $check_id = Questions::where('qsn_number', '2')->first()->id;
            $qsn_order = $check_id;
        }


        return $qsn_order;
    }

    public  static function checkQuestion5Previous($pivot_id, $qsn_id)
    {
        $questionDetail = Questions::where('qsn_number', 5)->first();
        $check_data = [];
        $data = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', $questionDetail->id)->first();

        if ($data != null) {
            $check_data['5.1'] = false;
            $check_data['5.2'] = false;
            $check_data['5.3'] = false;
            $options = explode(',', $data->answer);
            // dd($options);
            foreach ($options as $key => $option) {

                if ($option == '99') {
                    $check_data['5.1'] = true;
                } elseif ($option == '100') {
                    $check_data['5.2'] = true;
                } elseif ($option == '101') {
                    $check_data['5.3'] = true;
                }
            }
        }
        if (count($check_data) > 0) {

            if ($qsn_id == '17') {

                if ($check_data['5.3'] == true) {
                    $check_id = Questions::where('qsn_number', '5.3')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['5.2'] == true) {
                    $check_id = Questions::where('qsn_number', '5.2')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['5.1'] == true) {
                    $check_id = Questions::where('qsn_number', '5.1')->first()->id;
                    $qsn_order = $check_id;
                } else {
                    $check_id = Questions::where('qsn_number', '5')->first()->id;
                    $qsn_order = $check_id;
                }
            }
            if ($qsn_id == '42') {
                if ($check_data['5.2'] == true) {
                    $check_id = Questions::where('qsn_number', '5.2')->first()->id;
                    $qsn_order = $check_id;
                } elseif ($check_data['5.1'] == true) {
                    $check_id = Questions::where('qsn_number', '5.1')->first()->id;
                    $qsn_order = $check_id;
                } else {
                    $check_id = Questions::where('qsn_number', '5')->first()->id;
                    $qsn_order = $check_id;
                }
            }
            if ($qsn_id == '41') {
                if ($check_data['5.1'] == true) {
                    $check_id = Questions::where('qsn_number', '5.1')->first()->id;
                    $qsn_order = $check_id;
                } else {
                    $check_id = Questions::where('qsn_number', '5')->first()->id;
                    $qsn_order = $check_id;
                }
            }
        } else {
            $check_id = Questions::where('qsn_number', '2')->first()->id;
            $qsn_order = $check_id;
        }


        return $qsn_order;
    }
}
