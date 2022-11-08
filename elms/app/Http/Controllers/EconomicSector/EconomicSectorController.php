<?php

namespace App\Http\Controllers\EconomicSector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\EconomicSector\EconomicSectorRepository;
use App\Http\Requests\EconomicSector\EconomicSectorRequest;
use App\Models\EconomicSector\EconomicSector;
use App\Http\Requests\EconomicSector\EconomicSectorFilter;
use App\Models\Configuration\ProductAndServices;

class EconomicSectorController extends Controller
{
    /**
     * @var EconomicSectorRepository
     */
    private $economicSector;

    private  $economicSectorRepository;

    public function __construct(EconomicSectorRepository $economicSectorRepository , EconomicSector $economicSector, ProductAndServices $productAndServices)
    {

        $this->economicSectorRepository = $economicSectorRepository;

        $this->economicSector = $economicSector;

        $this->productAndServices = $productAndServices;
    }
    public function index(Request $request)
    {
        $economicsectors=$this->economicSectorRepository->all($request);
        $parents=$this->economicSectorRepository->parents();
        return view('backend.economic_sector.index',compact('parents','economicsectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EconomicSectorRequest $request)
    {

            try {
                $value=$request->all();
                if ($request->parent_id==null){
                    $value['parent_id']=0;
                }
                $create = $this->economicSector->create($value);
                if ($create) {
                    session()->flash('success', 'successfully created!');
                    return back();
                } else {
                    session()->flash('error', 'could not be created!');
                    return back();
                }

            } catch (\Exception $e) {
                $e = $e->getMessage();
                session()->flash('error', 'Exception : ' . $e);
                return back();
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
            $edits = $this->economicSectorRepository->findById($id);
            if ($edits->count() > 0) {
                $economicsectors = $this->economicSectorRepository ->all($request);
                $parents=$this->economicSectorRepository->parents();
                return view('backend.economic_sector.index', compact('edits', 'economicsectors','parents'));
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
    public function update(EconomicSectorRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $value=$request->all();
            if ($request->parent_id==null){
                $value['parent_id']=0;
            }
            $economicsector = $this->economicSectorRepository->findById($id);
            if ($economicsector) {
                $economicsector->fill($value)->save();
                session()->flash('success', 'Economic Sector updated successfully!');

                return redirect(route('economic_sector.index'));
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
            $value = $this->economicSectorRepository->findById($id);
            $getchild = $this->economicSector->where('parent_id',$value->id)->delete();
            $getProductAndServices = $this->productAndServices->where('sub_sector_id',$value->id)->delete();
            $value->delete();
            session()->flash('success', 'Economic Sector successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }


}
