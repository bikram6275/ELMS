<?php

namespace App\Http\Controllers\Api;

use App\Models\Answers;
use App\Models\WorkerSkills;
use Illuminate\Http\Request;
use App\Models\HumanResources;
use App\Models\SurveyEmpStatus;
use App\Models\TechnologyDetails;
use App\Models\BusinessFuturePlan;
use App\Http\Controllers\Controller;
use App\Models\OtherOccupationDetails;
use App\Repository\QuestionRepository;
use App\Models\TechnicalHumanResources;
use App\Repository\QuestionOptionsRepository;

class AnswerController extends Controller
{
    public function __construct(QuestionRepository $questionRepository, QuestionOptionsRepository $questionOptionsRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->questionOptionsRepository = $questionOptionsRepository;
    }

    public function store(Request $request)
    {

        try {
            $question = $this->questionRepository->findById($request->question_id);
            if ($question) {
                switch ($question->ans_type) {

                    case 'input':

                        return $this->saveInput($request);
                        break;

                    case 'radio':
                        return $this->saveRadio($request);
                        break;

                    case 'checkbox':
                        return $this->saveCheckbox($request);
                        break;

                    case 'multiple_input':
                        return $this->saveMultipleInput($request);
                        break;

                    case 'sector':
                        return $this->saveInput($request);
                        break;

                    case 'services':
                        return $this->saveCheckbox($request);
                        break;

                    case 'range':
                        $this->saveMultipleInputData($request);
                        break;

                    case 'external_table':
                        switch ($question->qsn_number) {

                            case '5.1':
                                $request['resource_type'] = "employer";
                                return $this->saveHumanResource($request);
                                break;
                            case '5.2':
                                $request['resource_type'] = "family_member";
                                $this->saveHumanResource($request);
                                break;
                            case '5.3':
                                $request['resource_type'] = "employees";
                                $this->saveHumanResource($request);
                                break;

                            case '6.a':
                                return $this->saveTechnicalHumanResourceData($request);
                                break;

                            case '6.b':
                                return $this->saveEmployeeStatusData($request);
                                break;
                            case '13':
                                return $this->saveQuestionNo13($request);
                                break;
                        }

                    case 'cond_radio':
                        switch ($question->qsn_number) {

                            case '8':
                                return $this->saveQuestionNo8($request);
                                break;

                            case '9':
                                return $this->saveQuestionNo9($request);
                                break;

                            case '17':
                                return $this->saveQuestionNo17($request);
                                break;
                            case '18':
                                return $this->saveQuestionNo18($request);
                                break;

                            default:
                                # code...
                                break;
                        }
                    case 'sub_qsn':
                        switch ($question->qsn_number) {

                            case '2':
                                return $this->saveQuestionNo2($request);
                                break;
                        }
                    default:
                        # code...
                        break;
                }
            } else {
                return response()->json(['message' => 'Question Doesnot Exist'], 422);
            }
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveInput($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['answer'] = $request->answer[0];
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveRadio($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['qsn_opt_id'] = $request->answer[0];
            $data['other_answer'] = isset($request->other_answer) ? $request->other_answer : null;
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveCheckbox($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['answer'] = implode(',', $request->answer);
            $data['other_answer'] = isset($request->other_answer) ? $request->other_answer : null;
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }
    public function saveMultipleInput($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;

            $data['answer'] = json_encode($request->answer[0]);
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return $ex;
            return response()->json([$ex], 500);
        }
    }
    public function saveHumanResource($request)
    {

        try {
            if($request['resource_type'] == 'employer')
                    {
                        HumanResources::where('enumerator_assign_id',$request->pivot_id)->where('resource_type','employer')->delete();
                    }
                    if($request['resource_type'] == 'family_member')
                    {
                        HumanResources::where('enumerator_assign_id',$request->pivot_id)->where('resource_type','family_member')->delete();
                    }
                    if($request['resource_type'] == 'employees')
                    {
                        HumanResources::where('enumerator_assign_id',$request->pivot_id)->where('resource_type','employees')->delete();
                    }
            foreach ($request['human_resource'] as $res_key => $working) {
                if ($working['male_count'] != null) {
                    $working['enumerator_assign_id'] = $request->pivot_id;
                    $working['resource_type'] = $request['resource_type'];
                    $working['working_type'] = $res_key;
                    $working['total'] = $working['nepali_count'] + $working['foreigner_count'] + $working['neighboring_count'];
                    
                    $result = HumanResources::create($working);
                }
            }
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
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
            'technical.*.edu_qua_tvet' => 'required',
            'technical.*.edu_qua_general' => 'required',

            'technical.*.ojt_apprentice' => 'required',
        ]);

        try {
            TechnicalHumanResources::where('enumerator_assign_id',$request->pivot_id)->delete();
            foreach ($request['technical'] as $key => $technical) {
                $technical['enumerator_assign_id'] = $request->pivot_id;
                $result = TechnicalHumanResources::create($technical);
            }
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveQuestionNo8($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['qsn_opt_id'] = $request->answer[0];
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);
            OtherOccupationDetails::where('enumerator_assign_id', $request->pivot_id)->delete();
            if ($options->option_name == 'Yes') {
                foreach ($request['occu'] as $occupation) {
                    $occupation['enumerator_assign_id'] = $request->pivot_id;
                    OtherOccupationDetails::create($occupation);
                }
            } 
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveQuestionNo2($request)
    {
        try {

            $data['enumerator_assign_id'] = $request->pivot_id;
            foreach ($request->answer as $qsn_id => $ans) {
                $data['qsn_id'] = $qsn_id;
                $data['answer'] = json_encode($ans['data']);
                $result = Answers::updateOrCreate(['id' => isset($ans['answer_id']) ? $ans['answer_id'] : 0], $data);
            }
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
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
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
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
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function saveQuestionNo9($request)
    {
        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['qsn_opt_id'] = $request->answer;
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);

            if ($options->option_name == 'No') {
                foreach ($request->optionalAnswer as $opt_key => $val) {
                    $sub_qsn['enumerator_assign_id'] = $request->pivot_id;
                    $sub_qsn['qsn_id'] = $opt_key;
                    $sub_qsn['answer'] = $val;
                    $result = Answers::updateOrCreate(['id' => isset($request->sub_qsn_id) ? $request->sub_qsn_id : 0], $sub_qsn);
                }
            } else {
                $child = $this->questionRepository->findchild($request->question_id);
                Answers::where('qsn_id', $child[0]->id)->delete();
            }
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }

    public function saveQuestionNo17($request)
    {

        try {
            $data['enumerator_assign_id'] = $request->pivot_id;
            $data['qsn_id'] = $request->question_id;
            $data['qsn_opt_id'] = $request->answer;
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            $options = $this->questionOptionsRepository->findById($data['qsn_opt_id']);

            if ($options->option_name == 'Yes') {

                $technology_details = $request->technology;
                $technology_details['enumerator_assign_id'] = $request->pivot_id;
                TechnologyDetails::updateOrCreate(['id' => isset($technology_details['id']) ? $technology_details['id'] : 0], $technology_details);
            } else {
                TechnologyDetails::where('enumerator_assign_id', $request->pivot_id)->delete();
            }

            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }
    public function saveQuestionNo18($request)
    {

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
            $data['qsn_id'] = $request->question_id;
            $result = Answers::updateOrCreate(['id' => $request->answer_id], $data);
            BusinessFuturePlan::where('enumerator_assign_id', $request->pivot_id)->delete();
            if ($options->option_name == 'Yes') {

                $skilled_details = $request->skilled;
                
                foreach ($skilled_details as $skill) {
                    if(!isset($skill['other_occupation_value'])){
                        $skill['other_occupation_value'] = null;
                    }
                    $skill['enumerator_assign_id'] = $request->pivot_id;
                    BusinessFuturePlan::create($skill);
                }
            } 
            return response()->json(['data' => 'Answered Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }
}
