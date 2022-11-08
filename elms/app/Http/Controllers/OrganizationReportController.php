<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Enumerable;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Repository\Report\OrganizationReportRepository;

class OrganizationReportController extends Controller
{
    protected $model;

    protected $districtRepository;

    protected $pradeshRepository;

    protected $sectorRepository;

    protected $organizationReportRepository;

    public function __construct(
        EnumeratorAssign $model, 
        DistrictRepository $districtRepository, 
        PradeshRepository $pradeshRepository, 
        EconomicSectorRepository $sectorRepository,
        OrganizationReportRepository $organizationReportRepository
        )
    {
        $this->model = $model;
        $this->districtRepository = $districtRepository;
        $this->pradeshRepository = $pradeshRepository;
        $this->sectorRepository = $sectorRepository;
        $this->organizationReportRepository = $organizationReportRepository;
    }


    public function index(Request $request){
        $approved_organizations = $this->organizationReportRepository->approvedOrganizations($request);
        $assigned_organizations = $this->organizationReportRepository->assignedOrganizations($request);
        $districts = $this->districtRepository->all();
        $pradeshes = $this->pradeshRepository->all();
        $sectors = $this->sectorRepository->parents();
        return view('backend.report.org_report',compact('approved_organizations','assigned_organizations','districts','pradeshes','sectors'));
    }
}
