<?php

namespace App\Http\Controllers;

use Question5Export;
use App\Models\Answers;
use App\Models\WorkerSkills;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\AnswersExport;
use App\Models\HumanResources;
use App\Exports\QuestionExport;
use App\Exports\RegisteredWith;
use App\Models\SurveyEmpStatus;
use App\Exports\EmpStatusExport;
use App\Exports\Question2Export;
use App\Exports\Question4Export;
use App\Exports\Question12Export;
use App\Exports\Question19Export;
use App\Exports\Question20Export;
use App\Exports\Question21Export;
use App\Exports\TechnologyExport;
use App\Models\TechnologyDetails;
use App\Exports\TechnicalHrExport;
use App\Exports\WorkerSkillExport;
use App\Models\BusinessFuturePlan;
use App\Repository\DataRepository;
use App\Exports\BusinessPlanExport;
use App\Exports\OrganizationExport;
use App\Exports\HumanResourceExport;
use App\Exports\MultipleSheetExport;
use App\Http\Controllers\Controller;
use App\Repository\AnswerRepository;
use App\Exports\OtherOccupationExport;
use App\Models\OtherOccupationDetails;
use App\Repository\QuestionRepository;
use App\Models\TechnicalHumanResources;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\SurveyOrgOccupationRepository;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use App\Exports\Question5Export as ExportsQuestion5Export;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\Configurations\ProductAndServiceRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class ReportController extends Controller
{
    private $enumeratorAssignRepository;
    private $questionRepository;
    private $answerRepository;
    private $economicSectorRepository;
    private $dataRepository;
    private $surveyOrgOccupationRepository;

    public function __construct( EnumeratorAssignRepository $enumeratorAssignRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository,
    EconomicSectorRepository $economicSectorRepository, DataRepository $dataRepository, SurveyOrgOccupationRepository $surveyOrgOccupationRepository, ProductAndServiceRepository $productAndServiceRepository){

        $this->enumeratorAssignRepository=$enumeratorAssignRepository;
        $this->questionRepository=$questionRepository;
        $this->answerRepository=$answerRepository;
        $this->economicSectorRepository=$economicSectorRepository;
        $this->dataRepository=$dataRepository;
        $this->surveyOrgOccupationRepository=$surveyOrgOccupationRepository;
        $this->productAndServiceRepository = $productAndServiceRepository;


    }

    public function organizationReport($survey_id)
    {

        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        $question=$this->questionRepository->all();
        $allsectors=$this->economicSectorRepository->all();
        $sectors=$allsectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        $skills = $this->dataRepository->skills();

        foreach($assignedOrganization as $val){
            $occupations = $this->surveyOrgOccupationRepository->orgOccupation($survey_id,$val->organization?$val->organization->sector_id:null);
            $answer[$val->organization_id]=$this->questionRepository->questionsWithAnswer($val->id);
            $humanResourcesData[$val->organization?$val->organization->org_name:null]=HumanResources::where('enumerator_assign_id',$val->id)->get()->groupBy(['resource_type', 'working_type']);
            $technicalData[$val->organization?$val->organization->org_name:null]=TechnicalHumanResources::with('tvetEducation','generalEducation')->where('enumerator_assign_id', $val->id)->get();
            $employmentStatus[$val->organization?$val->organization->org_name:null]=SurveyEmpStatus::where('enumerator_assign_id', $val->id)->get()->groupBy('occupation_id');
            $other_occupation[$val->organization?$val->organization->org_name:null]=OtherOccupationDetails::where('enumerator_assign_id', $val->id)->get();
            $skills_data[$val->organization?$val->organization->org_name:null]=WorkerSkills::where('enumerator_assign_id', $val->id)->get()->groupBy('skill');
            $technology[$val->organization?$val->organization->org_name:null] = TechnologyDetails::with('sector')->where('enumerator_assign_id', $val->id)->first();
            $business_plan[$val->organization?$val->organization->org_name:null] = BusinessFuturePlan::where('enumerator_assign_id', $val->id)->get();
            $a[] = $val->organization ? $val->organization->sector_id : $val ; 

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
    return FacadesExcel::download(new MultipleSheetExport($data),'orgReport.xlsx');

    }
    
    public function exportIndex($survey_id)
    {
        return view('backend.exports.index');
        
    }

    public function orgExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        return FacadesExcel::download(new OrganizationExport($assignedOrganization),'orgReport.xlsx');

    }

    public function questionExport($survey_id)
    {
        $question=$this->questionRepository->all();
        return FacadesExcel::download(new QuestionExport($question),'questionReport.xlsx');
    }

    public function answerExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        $question=$this->questionRepository->all();
        $allsectors=$this->economicSectorRepository->all();
        $sectors=$allsectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        foreach($assignedOrganization as $val){
            $occupations = $this->surveyOrgOccupationRepository->orgOccupation($survey_id,$val->organization?$val->organization->sector_id:null);
            $answer[$val->organization_id]=$this->questionRepository->questionsWithAnswer($val->id);
           
        }
        $data['question']=$question;
        $data['answer']=$answer;
        $data['sectors']=$sectors;
        return FacadesExcel::download(new AnswersExport($data),'answerReport.xlsx');
    }

    public function humanResourceExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        foreach($assignedOrganization as $val){
            $humanResourcesData[$val->organization?$val->organization->id:null]=HumanResources::where('enumerator_assign_id',$val->id)->get()->groupBy(['resource_type', 'working_type']);
        }
        $data['human_resource']['data']=$humanResourcesData;
        $data['human_resource']['humanResources']=$humanResources;
        $data['human_resource']['workers']=$workers;
        return FacadesExcel::download(new HumanResourceExport($data),'hrReport.xlsx');

    }

    public function techincalHumanResourceExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val){
            $technicalData[$val->organization?$val->organization->id:null]=TechnicalHumanResources::with('tvetEducation','generalEducation')->where('enumerator_assign_id', $val->id)->get();
        }
        $data['technical_hr']=$technicalData;
        return FacadesExcel::download(new TechnicalHrExport($data),'technical_hrReport.xlsx');

    }

    public function empStatusExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
         foreach($assignedOrganization as $val){
            $occupations[$val->organization?$val->organization->id:null] = $this->surveyOrgOccupationRepository->orgOccupation($survey_id,$val->organization?$val->organization->sector_id:null);
            $employmentStatus[$val->organization?$val->organization->id:null]=SurveyEmpStatus::where('enumerator_assign_id', $val->id)->get()->groupBy('occupation_id');
        }
        $data['employment']['data']=$employmentStatus;
        $data['employment']['occupation']=$occupations;
        return FacadesExcel::download(new EmpStatusExport($data),'empStatusReport.xlsx');

    }

    public function workerSkillExport($survey_id)
    {
        $skills = $this->dataRepository->skills();
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);

        foreach($assignedOrganization as $val){
            $skills_data[$val->organization?$val->organization->id:null]=WorkerSkills::where('enumerator_assign_id', $val->id)->get()->groupBy('skill');
        }
        $data['skill_data']['data']=$skills_data;
        $data['skill_data']['skills']=$skills;
        return FacadesExcel::download(new WorkerSkillExport($data),'workerSkillReport.xlsx');

    }

    public function otherOccupationExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val){
            $other_occupation[$val->organization?$val->organization->id:null]=OtherOccupationDetails::where('enumerator_assign_id', $val->id)->get();
        }
        $data['other_occupation']=$other_occupation;
        return FacadesExcel::download(new OtherOccupationExport($data),'otherOccupationReport.xlsx');
    }

    public function technologyExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        $allsectors=$this->economicSectorRepository->all();
        $sectors=$allsectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        foreach($assignedOrganization as $val){
            $technology[$val->organization?$val->organization->id:null] = TechnologyDetails::with('sector')->where('enumerator_assign_id', $val->id)->first();        }
            $data['technology']['data']=$technology;
            $data['technology']['sectors']=$sectors;
        return FacadesExcel::download(new TechnologyExport($data),'technologyExportReport.xlsx');
    }
    public function businessPlanExport($survey_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter($survey_id);
        
        foreach($assignedOrganization as $val){
            $business_plan[$val->organization?$val->organization->id:null] = BusinessFuturePlan::where('enumerator_assign_id', $val->id)->get();
        }
        $data['business_plan']=$business_plan;
        return FacadesExcel::download(new BusinessPlanExport($data),'businessPlanReport.xlsx');
    }

    public function qsn5Export($survey_id)
    {
        $assignedOrganization = EnumeratorAssign::where('survey_id',$survey_id)->where('status','supervised')->with('organization')->select('id','organization_id')->get();
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','39')->first(); 
        }
        $data= $answer;
        return FacadesExcel::download(new ExportsQuestion5Export($data),'question5Export.xlsx');
    }

    public function qsn12Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','25')->first();
        }
        return FacadesExcel::download(new Question12Export($answer),'question12Export.xlsx');
    }

    public function qsn20Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','33')->first();
        }

        // return $answer;
        return FacadesExcel::download(new Question20Export($answer),'question20Export.xlsx');

    }

    public function qsn21Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','35')->with('questionOption')->first();
        }

        return FacadesExcel::download(new Question21Export($answer),'question21Export.xlsx');
    }

    public function qsn2Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id]['9'] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','9')->first();
            $answer[$val->organization->id]['10'] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','10')->first();
            $answer[$val->organization->id]['11'] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','11')->first();
            $answer[$val->organization->id]['12'] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','12')->first();
            $answer[$val->organization->id]['13'] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','13')->first();


        }
        return FacadesExcel::download(new Question2Export($answer),'question2Export.xlsx');
    }

    public function registeredWithExport($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','3')->with('questionOption')->first();
        }
        return FacadesExcel::download(new RegisteredWith($answer),'question1.3.xlsx');
    
    
    }

    public function qsn4Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','15')->first();
            $serviceList= $this->productAndServiceRepository->all();
        }
        $data['answer'] = $answer;
        $data['services'] = $serviceList;
        return FacadesExcel::download(new Question4Export($data),'question4.xlsx');
    
    }
    
    public function qsn19Export($survey_id)
    {
        $assignedOrganization = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        foreach($assignedOrganization as $val)
        {
            $answer[$val->organization->id] = Answers::where('enumerator_assign_id',$val->id)->where('qsn_id','32')->first();
  
        }
        return FacadesExcel::download(new Question19Export($answer),'question19.xlsx');

    }

    
}
