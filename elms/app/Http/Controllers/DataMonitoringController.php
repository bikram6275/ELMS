<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repository\Emitter\EmitterRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use PDF;
class DataMonitoringController extends Controller
{
    protected $pradeshRepository;
    

    protected $districtRepository;
    

    protected $enumeratorRepository;
    
    
    protected $enumeratorAssignRepo;

    public function __construct(PradeshRepository $pradeshRepository, DistrictRepository $districtRepository, EmitterRepository $enumeratorRepository, EnumeratorAssignRepository $enumeratorAssignRepo)
    {
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->enumeratorRepository = $enumeratorRepository;
        $this->enumeratorAssignRepo = $enumeratorAssignRepo;
    }


    public function index(Request $request)
    {
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        $enumerators = $this->enumeratorRepository->all();
        $enumerator_details = $this->enumeratorAssignRepo->completedSurvey($request->enumerator_id);

        return view('backend.datamonitoring.datamonitoring',compact('pradeshes','districts','enumerators','enumerator_details'));
    }

    public function export($id)
    {
        $data = $this->enumeratorAssignRepo->completedSurvey($id);
        // view()->share('enumerator',$data);
        $pdf = PDF::loadView('backend.datamonitoring.export',['enumerator' => $data]);
        return $pdf->stream('enumeratorexport.pdf');
    }
}
