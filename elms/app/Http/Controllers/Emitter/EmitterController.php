<?php

namespace App\Http\Controllers\Emitter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\MunicipalityRepository;
use App\Repository\Emitter\EmitterRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Http\Requests\Emitter\EmitterRequest;
use App\Models\Emitter;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class EmitterController extends Controller
{
    /**
     * @var EmitterRepository
     */
    private $emitterRepository;
    /**
     * @var Emitter
     */
    private $emitter;
    /**
     * @var PradeshRepository
     */
    private $pradeshRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var MunicipalityRepository
     */
    private $municipalityRepository;
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;



    public function __construct(EmitterRepository $emitterRepository, Emitter $emitter, PradeshRepository $pradeshRepository, DistrictRepository $districtRepository,MunicipalityRepository $municipalityRepository,
                                OrganizationRepository $organizationRepository)
    {

        $this->emitterRepository = $emitterRepository;
        $this->emitter = $emitter;
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->municipalityRepository = $municipalityRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function index()
    {
        $emitters=$this->emitterRepository->all();
        return view('backend.emitter.index',compact('emitters'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pradeshes=$this->pradeshRepository->all();
        $districts=$this->districtRepository->all();
        $municipalities=$this->municipalityRepository->all();
        $supervisors = User::whereHas('user_group',function($query){
            $query->where('group_name','Supervisor');
        })->pluck('name','id');
//        $organizations=$this->organizationRepository->all($request);
        return view('backend.emitter.create',compact('pradeshes','districts','municipalities','supervisors'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmitterRequest $request)
    {
        try {
            $value=$request->all();
            $value['password']=bcrypt($request->password);
            $create = $this->emitter->create($value);
            if ($create) {
                Mail::send('backend.email.emitterUser', ['password' => $request->password], function ($m) use ($request) {
                    $m->to($request->email)->subject('User Registration Information');
                });
                session()->flash('success', 'emitter successfully added');
                return redirect(route('emitter.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('emitter.index'));
            }

        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('emitter.index'));
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
        try {
            $emitter = $this->emitterRepository->findById($id);
            if ($emitter) {
                return view('backend.emitter.show', compact('emitter'));
            } else {
                return back();
            }
        } catch (\Exception $e) {
            $e->getMessage();
            session()->flash('error', 'Something went Wrong!!');
            return back();
        }
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
            $edits = $this->emitterRepository->findById($id);
            $pradeshes=$this->pradeshRepository->all();
            $districts=$this->districtRepository->findDistrict($edits->pradesh_id);
            $municipalities=$this->municipalityRepository->findMunicipality($edits->district_id);
            $organizations=$this->organizationRepository->all($request);
            $supervisors = User::whereHas('user_group',function($query){
                $query->where('group_name','Supervisor');
            })->pluck('name','id');

            if ($edits->count() > 0) {
                $emitters=$this->emitterRepository->all();
                return view('backend.emitter.edit', compact('supervisors','emitters','edits','pradeshes','districts','municipalities','organizations'));
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
    public function update(EmitterRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $emitter = $this->emitterRepository->findById($id);
            if ($emitter) {
                $value = $request->all();
                $emitter->fill($value)->save();

                if ($emitter) {
                    session()->flash('success', 'Emitter updated successfully!');
                    return redirect(route('emitter.index'));
                } else {
                    session()->flash('error', 'No record with given id!');
                    return back();
                }
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
            $emitter = $this->emitterRepository->findById($id);
            if($emitter->survey)
            {
               session()->flash('error','Cannot delete the enumerator. Already assigned to a survey'); 
               return back();

            }
            if ($emitter) {
                $emitter->delete();
                session()->flash('success', 'emitter successfully deleted!');
                return back();
            } else {
                session()->flash('error', 'Emitter could not be delete!');
                return back();
            }

        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function changePassword(Request $request,$id)
    {
        $emitter = $this->emitterRepository->findById($id);
        if ($emitter) {
            $emitter->update([
                'password' => bcrypt($request->password),
                'email' => $request->email
            ]);
            session()->flash('success', 'Emitter Login Information successfully updated!');
            return back();
        } else {
            session()->flash('error', 'Emitter with the id not found!');
            return back();
        }

    }
}
