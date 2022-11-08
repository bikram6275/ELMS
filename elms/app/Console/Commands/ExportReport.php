<?php

namespace App\Console\Commands;

use App\Models\WorkerSkills;
use App\Models\HumanResources;
use App\Models\SurveyEmpStatus;
use Illuminate\Console\Command;
use App\Models\TechnologyDetails;
use App\Models\BusinessFuturePlan;
use App\Repository\DataRepository;
use App\Exports\MultipleSheetExport;
use App\Repository\AnswerRepository;
use App\Models\OtherOccupationDetails;
use App\Repository\QuestionRepository;
use App\Models\TechnicalHumanResources;
use App\Repository\SurveyOrgOccupationRepository;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class ExportReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EnumeratorAssignRepository $enumeratorAssignRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository,
    EconomicSectorRepository $economicSectorRepository, DataRepository $dataRepository, SurveyOrgOccupationRepository $surveyOrgOccupationRepository){
        parent::__construct();

        $this->enumeratorAssignRepository=$enumeratorAssignRepository;
        $this->questionRepository=$questionRepository;
        $this->answerRepository=$answerRepository;
        $this->economicSectorRepository=$economicSectorRepository;
        $this->dataRepository=$dataRepository;
        $this->surveyOrgOccupationRepository=$surveyOrgOccupationRepository;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $assignedOrganization=$this->enumeratorAssignRepository->orgsFilter('1');
        $question=$this->questionRepository->all();
        $allsectors=$this->economicSectorRepository->all();
        $sectors=$allsectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        $skills = $this->dataRepository->skills();

        foreach($assignedOrganization as $val){
            $occupations = $this->surveyOrgOccupationRepository->orgOccupation('1',$val->organization?$val->organization->sector_id:null);
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
}
