<?php

namespace App\Http\Controllers;

use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use Illuminate\Http\Request;

class SurveyListController extends Controller
{

    private $enumeratorAssignRepository;
    protected $pradesh;

    protected $district;

    public function __construct(EnumeratorAssignRepository $enumeratorAssignRepository, PradeshRepository $pradesh, DistrictRepository $district)
    {
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
        $this->pradesh = $pradesh;
        $this->district = $district;
    }

    public function index()
    {
        $surveys = $this->enumeratorAssignRepository->getAllSurveyList();
        return view('admin.survey_list.index', compact('surveys'));
    }
    public function getOrgList(Request $request, $id)
    {
        $pradeshs = $this->pradesh->all();
        $districts = $this->district->all();
        $assignOrganization = $this->enumeratorAssignRepository->getApprovedOrganizations($request);
        return view('admin.survey_list.organization', compact('assignOrganization','pradeshs','districts'));
    }

    public function returnToCoordinator($id)
    {
        $result = EnumeratorAssign::find($id);
        $result = $result->update(['status' => 'field_supervised']);
        return redirect()->back();
    }
}
