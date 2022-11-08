<?php

namespace App\Http\Resources;

use App\Models\Configuration\EconomicSector;
use App\Models\Configuration\ProductAndServices;
use App\Repository\DataRepository;
use App\Models\Occupation\Occupation;
use App\Models\Education\EducationQualification;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Models\HumanResources;
use App\Models\SurveyEmpStatus;
use App\Models\TechnicalHumanResources;
use App\Models\WorkerSkills;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    //public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $enumerator_assign = EnumeratorAssign::where('id', $request->pivot_id)->first();
        $sector_occupation = Occupation::where('sector_id', $enumerator_assign->organization->sector->id)->get();
        # get survey_occcupations for q.no = 6.b
        $survey_occupations = Occupation::where('sector_id', $enumerator_assign->organization->sector->id)->whereHas('surveyOccupation')->get();

        $general_qualification = EducationQualification::where('type', 'general')->get();
        $tvet = EducationQualification::where('type', 'tvet')->get();
        $re = SurveyEmpStatus::where('enumerator_assign_id', $request->pivot_id)->get();

        $result = [
            'id' => $this->id,
            'qsn_number' => $this->qsn_number,
            'qsn_name' => $this->qsn_name,
            'ans_type' => $this->ans_type,
            'qsn_status' => $this->qst_status,
            'required' => $this->required,
            'instruction' => $this->instruction,
            # for keyboard type for input field
            $this->mergeWhen($this->ans_type == 'input', [
                'input_type' => $this->input_type
            ]),
            # when questionOptions are available i.e for ans_type like radio, checkbox, etc
            'question_options' => $this->when(!$this->questionOption->isEmpty(), $this->questionOption()->select('id', 'qsn_id', 'option_number', 'option_name', 'option_order', 'option_type', 'options')->get()),

            # merge for question no 3 i.e id = 11 
            $this->mergeWhen($this->id == 14, [
                'sector' => $enumerator_assign->organization->sector,
                'sub_sectors' => $enumerator_assign->organization->sector->subsector($enumerator_assign->organization->sector->id)
            ]),

            # merge for question no 5 i.e id = 16
            $this->mergeWhen($this->id == 16, [
                'human_resource' =>  DataRepository::humanResourceList(),
                'workers' => DataRepository::workersList(),
                'answer' => HumanResources::where('enumerator_assign_id', $request->pivot_id)->get()
            ]),

            # merge for question no 6.a i.e id =17
            $this->mergeWhen($this->id == 17, [
                'occupations' =>  $sector_occupation,
                'working_hour' => ['Full time(40 hours and +)', 'Part time(less than 40 hours)'],
                'nature_of_work' => ['Regular', 'Seasonal'],
                'training' => ['Trained', 'Untrained'],
                'educational_qualification_general' => $general_qualification,
                'educational_qualification_tvet' => $tvet,
                'answer' => TechnicalHumanResources::where('enumerator_assign_id', $request->pivot_id)->get()
            ]),

            # merge for question no 6.b i.e id = 18
            $this->mergeWhen($this->id == 18, [
                'sector' =>  $enumerator_assign->organization->sector,
                'occupations' => $survey_occupations,
                'answer' => $re
            ]),

            #merge for question no 13 i.e id = 27
            $this->mergeWhen($this->id == 27, [
                'worker_skills' => DataRepository::skills()
            ]),

            #merge for question no 2 i.e id = 8
            $this->mergeWhen($this->id == 8, [
                'sub_questions' => $this->subQuestionWithAnswer($this->id, $request->pivot_id),

            ]),

            #merge for question no 8 i.e id = 20
            $this->mergeWhen($this->id == 20, [
                'occupation' => $sector_occupation,
                'answer' => $this->orgQuestionAnswer($request->pivot_id, $this->id),
            ]),
            # merge for question no 9
            $this->mergeWhen($this->qsn_number == 9, [
                'conditional_question' => $this->where('qsn_number', '9.1')->get()
            ]),
            # merge for question no 13
            $this->mergeWhen($this->qsn_number == 13, [
                'answer' => WorkerSkills::where('enumerator_assign_id', $request->pivot_id)->get()
            ]),

            # merge for question no 17
            $this->mergeWhen($this->qsn_number == 17, [
                'sector' => EconomicSector::where('parent_id', 0)->get(),
                'conditional_question' => $this->where('qsn_number', '17.1')->get()
            ]),

            #merge for question no 18
            $this->mergeWhen($this->qsn_number == 18, [
                'sector' => EconomicSector::where('parent_id', 0)->get(),
            ]),

            $this->mergeWhen($this->qsn_number == 5.1, [
                'workers' =>DataRepository::workersList(),
                'answer' => HumanResources::where('enumerator_assign_id', $request->pivot_id)->where('resource_type', 'employer')->get(),
            ]),
            $this->mergeWhen($this->qsn_number == 5.2, [
                'workers' => DataRepository::workersList(),
                'answer' => HumanResources::where('enumerator_assign_id', $request->pivot_id)->where('resource_type', 'family_member')->get()
            ]),
            $this->mergeWhen($this->qsn_number == 5.3, [
                'workers' => DataRepository::workersList(),
                'answer' => HumanResources::where('enumerator_assign_id', $request->pivot_id)->where('resource_type', 'employees')->get()
            ]),

            'answer' => $this->orgQuestionAnswer($request->pivot_id, $this->id),

        ];

        return $result;
    }
}
