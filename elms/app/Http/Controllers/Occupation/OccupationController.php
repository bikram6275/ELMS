<?php

namespace App\Http\Controllers\Occupation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Occupation\OccupationRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Models\Occupation\Occupation;
use App\Http\Requests\Occupation\OccupationRequest;
use App\Models\SurveyEmpStatus;
use App\Models\TechnicalHumanResources;

use function PHPUnit\Framework\assertLessThan;

class OccupationController extends Controller
{
    /**
     * @var OccupationRepository
     */
    private $occupation;

    private  $occupationRepository;
    /**
     * @var EconomicSectorRepository
     */
    private $economicsector;

    public function __construct(OccupationRepository $occupationRepository , Occupation $occupation, EconomicSectorRepository $economicsector)
    {

        $this->occupationRepository = $occupationRepository;

        $this->occupation = $occupation;
        $this->economicsector = $economicsector;
    }

    public function index(Request $request)
    {
        $occupations=$this->occupationRepository->all($request);
        $economicsectors=$this->economicsector->parents();
        return view('backend.occupation.index',compact('occupations','economicsectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $occupations=$this->occupationRepository->all($request);
        $economicsectors=$this->economicsector->parents();
        return view('backend.occupation.add',compact('occupations','economicsectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OccupationRequest $request)
    {
        try {
            $value=$request->all();
            $countoccupation=Count($request->occupation_name);
            if($countoccupation != NULL){
            for($i=0; $i<$countoccupation ;$i++){
                $create = $this->occupation->insert([
                    'sector_id'=>$request->sector_id,
                    'occupation_name'=>$request->occupation_name[$i],
                ]);
            }
        }

            if ($create) {
                session()->flash('success', 'Occupation successfully added');
                return redirect(route('occupation.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('occupation.index'));
            }

        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('occupation.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        try {
            $id = (int)$id;
            $edits = $this->occupationRepository->findById($id);
            if ($edits->count() > 0) {
                $economicsectors=$this->economicsector->parents();
                $occupations=$this->occupationRepository->all($request);
                return view('backend.occupation.edit', compact('edits', 'occupations','economicsectors'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OccupationRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $occupation = $this->occupationRepository->findById($id);
            if ($occupation) {
                $occupation->fill($request->all())->save();
                session()->flash('success', 'Occupation updated successfully!');

                return redirect(route('occupation.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            if((TechnicalHumanResources::where('occupation_id',$id)->get())->count() > 0)
            {
                session()->flash('error', 'Cannot delete this occupation its being used in survey!');
                return back();
            }
            elseif((SurveyEmpStatus::where('occupation_id',$id)->get())->count() > 0)
            {
                session()->flash('error', 'Cannot delete this occupation its being used in survey!');
                return back();
            }
            $value = $this->occupationRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Occupation successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function filterOccupation($id)
    {
       $occupation = $this->occupationRepository->sectoroccup($id);
       return $occupation;
    }
}
