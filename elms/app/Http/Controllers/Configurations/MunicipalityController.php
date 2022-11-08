<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\District;
use App\Models\Configuration\MuniType;
use App\Models\Configuration\Municipality;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\MuniTypeRepository;
use App\Http\Requests\Configurations\MunicipalityRequest;
use App\Repository\Configurations\MunicipalityRepository;

class MunicipalityController extends Controller
{
    /**
     * @var MunicipalityRepository
     */
    private $municipalityRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var MuniTypeRepository
     */
    private $muniTypeRepository;

    /**
     * MunicipalityController constructor.
     */
    public function __construct(
        MunicipalityRepository $municipalityRepository,
        DistrictRepository $districtRepository,
        MuniTypeRepository $muniTypeRepository
    ) {
        
        $this->municipalityRepository = $municipalityRepository;
        $this->districtRepository = $districtRepository;
        $this->muniTypeRepository = $muniTypeRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $district = $this->districtRepository->all();
        $muniType = $this->muniTypeRepository->all();
        $municipalities = $this->municipalityRepository->all();
        return view('backend.configurations.municipality.index', compact('district', 'muniType', 'municipalities'));
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
    public function store(MunicipalityRequest $request)
    {
        try {
            $create = Municipality::create($request->all());
            if ($create) {
                session()->flash('success', 'Municipality successfully created!');
                return back();
            } else {
                session()->flash('error', 'Municipality could not be created!');
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
            $edits = $this->municipalityRepository->findById($id);
            if ($edits->count() > 0) {
                $district = District::select('id', 'nepali_name')->get();
                $muniType = MuniType::select('id', 'muni_type_name')->get();
                $municipalities = $this->municipalityRepository->all();
                return view('backend.configurations.municipality.index', compact('edits', 'district', 'muniType', 'municipalities'));
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
    public function update(MunicipalityRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $municipalities = $this->municipalityRepository->findById($id);
            if ($municipalities) {
                $municipalities->fill($request->all())->save();
                session()->flash('success', 'Municipality updated successfully!');

                return redirect(route('municipality.index'));
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
            $value = $this->municipalityRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Municipality successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
