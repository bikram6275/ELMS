<?php

namespace App\Http\Controllers;

use App\Models\FeedbackLog;
use App\Models\WorkerSkills;
use Illuminate\Http\Request;
use App\Models\HumanResources;
use App\Models\SurveyEmpStatus;
use App\Models\TechnologyDetails;
use App\Models\BusinessFuturePlan;
use App\Repository\DataRepository;
use App\Repository\AnswerRepository;
use App\Models\OtherOccupationDetails;
use App\Repository\QuestionRepository;
use App\Models\TechnicalHumanResources;
use App\Repository\Emitter\EmitterRepository;
use App\Repository\SurveyOrgOccupationRepository;
use App\Repository\Occupation\OccupationRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\Configurations\ProductAndServiceRepository;
use App\Repository\Education\EducationQualificationRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class SurveyResponseController extends Controller
{
    private $enumeratorAssignRepository;

    protected $organizationRepository;

    protected $questionRepository;

    public function __construct(
        EnumeratorAssignRepository $enumeratorAssignRepository, 
        OrganizationRepository $organizationRepository, 
        QuestionRepository $questionRepository,
        EconomicSectorRepository $economicSectorRepository,
        DataRepository $dataRepository,
        EducationQualificationRepository $eduQualificationRepository,
        AnswerRepository $answerRepository,
        SurveyOrgOccupationRepository $surveyOrgOccupationRepository,
        ProductAndServiceRepository $productAndServiceRepository,
        OccupationRepository $occupationRepository,
        EmitterRepository $emitterRepository,
        )
    {
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
        $this->organizationRepository = $organizationRepository;
        $this->questionRepository = $questionRepository;
        $this->economicSectorRepository = $economicSectorRepository;
        $this->dataRepository = $dataRepository;
        $this->eduQualificationRepository = $eduQualificationRepository;
        $this->answerRepository = $answerRepository;
        $this->surveyOrgOccupationRepository = $surveyOrgOccupationRepository;
        $this->productAndServiceRepository=$productAndServiceRepository;
        $this->occupationRepository=$occupationRepository;
        $this->emitterRepository = $emitterRepository;
    }

    public function index()
    {
        $surveys = $this->enumeratorAssignRepository->getAllSurveyList();
        return view('backend.survey_response.index', compact('surveys'));
    }

    public function show(Request $request)
    {
        $rows = $this->enumeratorAssignRepository->getSupervisorOrganizations($request);
        $assignedCount = $this->enumeratorAssignRepository->supervisorAssignedCount($request);
        $approvedCount = $this->enumeratorAssignRepository->supervisorApprovedCount($request);
        $feedbackCount = $this->enumeratorAssignRepository->supervisorFeedbackCount($request);
        $enumerators = $this->emitterRepository->supervisorEmitters();
        return view('backend.survey_response.organization', compact('rows','enumerators','assignedCount','approvedCount','feedbackCount'));
    }

    public function viewResponse($pivot_id)
    {
        $assignedOrganization=$this->enumeratorAssignRepository->findById($pivot_id);
        $assignedorgId=$assignedOrganization->organization_id;
        $org_details=$this->organizationRepository->findById($assignedorgId);
        $questions = $this->questionRepository->questionsWithAnswer($pivot_id);
        $sectors = $this->economicSectorRepository->all();
        $allsectors=$sectors->mapWithKeys(function($value){
            return [$value['id'] => $value['sector_name']];
        });
        $answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','employer')->get()->groupBy(['working_type']);
        $family_answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','family_member')->get()->groupBy([ 'working_type']);
        $employee_answer = HumanResources::where('enumerator_assign_id', $pivot_id)->where('resource_type','employees')->get()->groupBy(['working_type']);        $humanResources = $this->dataRepository->humanResource();
        $workers = $this->dataRepository->workers();
        $technicalAnswer = TechnicalHumanResources::with('generalEducation','tvetEducation','sector','occupation')->where('enumerator_assign_id', $pivot_id)->get();
        $occupations = $this->surveyOrgOccupationRepository->orgOccupation($assignedOrganization->survey_id,$assignedOrganization->organization->sector_id);
        $empStatusAnswer = SurveyEmpStatus::where('enumerator_assign_id', $pivot_id)->get()->groupBy('occupation_id');
        $othter_occupationAnswer = OtherOccupationDetails::where('enumerator_assign_id', $pivot_id)->get();
        $skills = $this->dataRepository->skills();
        $skillAnswer=WorkerSkills::where('enumerator_assign_id', $pivot_id)->get()->groupBy('skill');
        $technology_details=TechnologyDetails::with('sector')->where('enumerator_assign_id', $pivot_id)->first();
        $business_plans=BusinessFuturePlan::where('enumerator_assign_id', $pivot_id)->get();
        $sub_sector = $this->answerRepository->findByQsnId(14, $pivot_id);
        $services='';
                if($sub_sector!=null){
                    $sub_sector_id=$sub_sector->answer;
                    $serviceList=$this->productAndServiceRepository->findBySecor($sub_sector_id);
                    $services=$serviceList->mapWithKeys(function($value){
                        return [$value['id'] => $value['product_and_services_name']];
                    });
                }
        $is_supervisor = auth()->user()->user_group->group_name == 'Supervisor' ? true : false;
        $is_approved = $assignedOrganization->status == 'supervised'? true : false;
        $feedbacks = FeedbackLog::where('enumerator_assign_id',$pivot_id)->get();

       return view('emitter.answer.show',compact('feedbacks','is_approved','assignedOrganization','org_details','questions','sectors','humanResources','answer','workers','technicalAnswer','occupations','empStatusAnswer','othter_occupationAnswer','skills','skillAnswer','technology_details','allsectors','business_plans','services','family_answer','employee_answer','is_supervisor'));
    }

    public function approveResponse($id)
    {
        $result=$this->enumeratorAssignRepository->findById($id);
        $result = $result->update(['status'=>'field_supervised']);
        return redirect()->route('survey.response.show',$id);
    }
}
