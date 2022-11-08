<?php

namespace App\Http\Controllers\Emitter;

use App\Exports\MultipleSheetExport;
use App\Exports\OrganizationExport;
use App\Http\Controllers\Controller;
use App\Models\BusinessFuturePlan;
use App\Models\HumanResources;
use App\Models\OtherOccupationDetails;
use App\Models\SurveyEmpStatus;
use App\Models\TechnicalHumanResources;
use App\Models\TechnologyDetails;
use App\Models\WorkerSkills;
use App\Repository\AnswerRepository;
use App\Repository\DataRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use App\Repository\QuestionRepository;
use App\Repository\SurveyOrgOccupationRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ReportController extends Controller
{
    private $enumeratorAssignRepository;
    private $questionRepository;
    private $answerRepository;
    private $economicSectorRepository;
    private $dataRepository;
    private $surveyOrgOccupationRepository;

    public function __construct( EnumeratorAssignRepository $enumeratorAssignRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository,
    EconomicSectorRepository $economicSectorRepository, DataRepository $dataRepository, SurveyOrgOccupationRepository $surveyOrgOccupationRepository){

        $this->enumeratorAssignRepository=$enumeratorAssignRepository;
        $this->questionRepository=$questionRepository;
        $this->answerRepository=$answerRepository;
        $this->economicSectorRepository=$economicSectorRepository;
        $this->dataRepository=$dataRepository;
        $this->surveyOrgOccupationRepository=$surveyOrgOccupationRepository;


    }

    public function organizationReport($survey_id)
    {
        $enumerator_id=auth()->user()->id;
        $assignedOrganization=$this->enumeratorAssignRepository->filter($enumerator_id,$survey_id);
        $question=$this->questionRepository->all();
        $allsectors=$this->economicSectorRepository->all();
        $sectors=$allsectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        $skills = $this->dataRepository->skills();
        foreach($assignedOrganization as $val){
            $occupations = $this->surveyOrgOccupationRepository->orgOccupation($survey_id,$val->organization->sector_id);
            $answer[$val->organization_id]=$this->questionRepository->questionsWithAnswer($val->id);
            $humanResourcesData[$val->organization->org_name]=HumanResources::where('enumerator_assign_id',$val->id)->get()->groupBy(['resource_type', 'working_type']);
            $technicalData[$val->organization->org_name]=TechnicalHumanResources::with('education')->where('enumerator_assign_id', $val->id)->get();
            $employmentStatus[$val->organization->org_name]=SurveyEmpStatus::where('enumerator_assign_id', $val->id)->get()->groupBy('occupation_id');
            $other_occupation[$val->organization->org_name]=OtherOccupationDetails::where('enumerator_assign_id', $val->id)->get();
            $skills_data[$val->organization->org_name]=WorkerSkills::where('enumerator_assign_id', $val->id)->get()->groupBy('skill');
            $technology[$val->organization->org_name] = TechnologyDetails::with('sector')->where('enumerator_assign_id', $val->id)->first();
            $business_plan[$val->organization->org_name] = BusinessFuturePlan::where('enumerator_assign_id', $val->id)->get();

        }
        $data['organization']=$assignedOrganization;
        $data['question']=$question;
        $data['answer']=$answer;
        $data['sectors']=$sectors;

        $data['human_resource']['data']=$humanResourcesData;
        $data['human_resource']['humanResources']=$humanResources;
        $data['human_resource']['workers']=$workers;

        $data['technical_hr']=$technicalData;

        $data['employment']['data']=$employmentStatus;
        $data['employment']['occupation']=$occupations;

        $data['other_occupation']=$other_occupation;

        $data['skill_data']['data']=$skills_data;
        $data['skill_data']['skills']=$skills;

        $data['technology']['data']=$technology;
        $data['technology']['sectors']=$sectors;

        $data['business_plan']=$business_plan;

    return FacadesExcel::download(new MultipleSheetExport($data), 'orgReport.xlsx');
    }
}
