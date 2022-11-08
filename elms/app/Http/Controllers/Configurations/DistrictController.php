<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\Pradesh;
use App\Models\Configuration\District;
use App\Models\Configuration\Municipality;
use App\Repository\Configurations\PradeshRepository;
use App\Http\Requests\Configurations\DistrictRequest;
use App\Repository\Configurations\DistrictRepository;

class DistrictController extends Controller
{
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var PradeshRepository
     */
    private $pradeshRepository;

    /**
     * DistrictController constructor.
     */
    public function __construct(
        DistrictRepository $districtRepository,
        PradeshRepository $pradeshRepository
    ) {
        
        $this->districtRepository = $districtRepository;
        $this->pradeshRepository = $pradeshRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = $this->districtRepository->all();
        $pradesh = $this->pradeshRepository->all();
        return view('backend.configurations.district.index', compact('districts', 'pradesh'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request)
    {
        try {
            $create = District::create($request->all());
            if ($create) {
                session()->flash('success', 'District successfully created!');
                return back();
            } else {
                session()->flash('error', 'District could not be created!');
                return back();
            }
        } catch (\Exception $e) {
            $e->getMessage();
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
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->districtRepository->findById($id);
            if ($edits->count() > 0) {
                $pradesh = Pradesh::select('id', 'pradesh_name')->get();
                $districts = $this->districtRepository->all();
                return view('backend.configurations.district.index', compact('edits', 'districts', 'pradesh'));
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
    public function update(DistrictRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $district = $this->districtRepository->findById($id);
            if ($district) {
                $district->fill($request->all())->save();
                session()->flash('success', 'District updated successfully!');

                return redirect(route('district.index'));
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
            $value = $this->districtRepository->findById($id);

            if ($value) {
                $valueId = $value->id;
                $muni = Municipality::where('district_id', $valueId)->get();

                if (count($muni) > 0) {
                    session()->flash('error', 'District is in use. Unable to delete!');
                    return back();
                }
                $value->delete();
                session()->flash('success', 'District successfully deleted!');
                return back();
            } else {
                session()->flash('error', 'District could not be deleted!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
