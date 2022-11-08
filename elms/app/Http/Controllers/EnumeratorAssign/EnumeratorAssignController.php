<?php

namespace App\Http\Controllers\EnumeratorAssign;

use App\Http\Controllers\Controller;
use App\Models\Emitter;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\Configurations\DistrictRepository;
use App\Repository\Configurations\MunicipalityRepository;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Emitter\EmitterRepository;
use App\Repository\Survey\SurveyRepository;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EnumeratorAssign\EnumeratorAssignRequest;

class EnumeratorAssignController extends Controller
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

    /**
     * @var SurveyRepository
     */
    private $surveyRepository;
    /**
     * @var EnumeratorAssign
     */
    private $enumeratorAssign;
    /**
     * @var EnumeratorAssignRepository
     */
    private $enumeratorAssignRepository;

    public function __construct(
        EmitterRepository $emitterRepository,
        Emitter $emitter,
        PradeshRepository $pradeshRepository,
        DistrictRepository $districtRepository,
        MunicipalityRepository $municipalityRepository,
        OrganizationRepository $organizationRepository,
        SurveyRepository $surveyRepository,
        EnumeratorAssign $enumeratorAssign,
        EnumeratorAssignRepository $enumeratorAssignRepository
    ) {


        $this->emitterRepository = $emitterRepository;
        $this->emitter = $emitter;
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->municipalityRepository = $municipalityRepository;
        $this->organizationRepository = $organizationRepository;
        $this->surveyRepository = $surveyRepository;
        $this->enumeratorAssign = $enumeratorAssign;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
    }

    public function index(Request $request)
    {
        $enumerator_id = $request->enumerator_id;
        $survey_id = $request->survey_id;
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        // $organizations=$this->organizationRepository->all($request);
        $organizations = $this->organizationRepository->filter($request);
        $emitters = $this->emitterRepository->all();
        $surveys = $this->surveyRepository->getSurvey();
        $assigned = $this->enumeratorAssignRepository->filter($enumerator_id, $survey_id);
        $enumeratorAssigns = $assigned->mapWithKeys(function ($item) {
            return [$item['organization_id'] => $item['survey_id']];
        })->toArray();

        //        $assignedOrgs = $this->enumeratorAssignRepository->orgsFilter($survey_id);
        //        $enumeratorOrgsAssigns = $assignedOrgs->mapWithKeys(function ($item) {
        //            return [$item['organization_id'] => $item['survey_id']];
        //        })->toArray();

        $status = false;
        if ($request->all() != null) {
            $status = true;
        }
        return view('backend.enumeratorassign.index', compact('pradeshes', 'districts','organizations', 'emitters', 'surveys', 'enumeratorAssigns', 'enumerator_id', 'survey_id', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //        $pradeshes=$this->pradeshRepository->all();
        //        $districts=$this->districtRepository->all();
        //        $municipalities=$this->municipalityRepository->all();
        //        $organizations=$this->organizationRepository->all($request);
        //        $emitters=$this->emitterRepository->all();
        //        $surveys=$this->surveyRepository->all($request);
        //        $enumeratorAssigns=$this->enumeratorAssignRepository->all();
        //        return view('backend.enumeratorassign.create',compact('pradeshes','districts','municipalities','organizations','emitters','surveys','enumeratorAssigns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnumeratorAssignRequest $request)
    {
        DB::beginTransaction();
        try {
            $value = $request->all();
            if ($request->ids == null && $request->has('enumerator_id') && $request->enumerator_id != null && $request->has('survey_id') && $request->survey_id != null) {
                $oldData = EnumeratorAssign::where('emitter_id', $request->enumerator_id)->where('survey_id', $request->survey_id)->get();
                if ($oldData) {

                    foreach ($oldData as $data) {
                        $id = $data->id;

                        $result = $this->enumeratorAssignRepository->findById($id);
                        if ($result) {
                            $update = $value['emitter_id'] = null;
                            $result->fill($value)->save();
                            DB::commit();
                        }
                    }
                    session()->flash('success', 'Enumerator UnAssigned successfully');
                    return redirect(route('enumeratorassign.index'));
                }
            }

            if (
                $request->has('ids') && $request->ids != null && $request->has('enumerator_id') &&
                $request->enumerator_id != null && $request->has('survey_id') && $request->survey_id != null
            ) {

                $oldData = EnumeratorAssign::where('emitter_id', $request->enumerator_id)->where('survey_id', $request->survey_id)->get();

                if (!$oldData->isEmpty()) {
                    foreach ($oldData as $data) {
                        $id = $data->id;
                        $result = $this->enumeratorAssignRepository->findById($id);
                        if ($result) {
                            $update = $value['emitter_id'] = null;
                            $result->fill($value)->save();
                        }
                    }
                    for ($i = 0; $i < count($request->ids); $i++) {

                        $old = EnumeratorAssign::where('survey_id', $request->survey_id)->where('organization_id', $request->ids[$i])->get();
                        if (!$old->isEmpty()) {
                            $upadte = EnumeratorAssign::where('survey_id', $request->survey_id)->where('organization_id', $request->ids[$i])->update([
                                'emitter_id' => $request->enumerator_id,
                            ]);
                        } else {
                            $data = array(
                                'emitter_id' => $request->enumerator_id,
                                'survey_id' => $request->survey_id,
                                'organization_id' => $request->ids[$i],
                            );

                            $this->enumeratorAssign->insert($data);
                        }
                    }

                    DB::commit();
                    session()->flash('success', 'Enumerator Assigned successfully');
                    return redirect(route('enumeratorassign.index'));
                }
            }
            //
            for ($i = 0; $i < count($request->ids); $i++) {

                $resultData = EnumeratorAssign::where('survey_id', $request->survey_id)->where('organization_id', $request->ids[$i])->where('emitter_id', null)->get();

                if (!$resultData->isEmpty()) {
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $upadte = EnumeratorAssign::where('survey_id', $request->survey_id)->where('organization_id', $request->ids[$i])->where('emitter_id', null)->update([
                            'emitter_id' => $request->enumerator_id,
                        ]);
                    }
                } else {
                    $data = array(
                        'emitter_id' => $request->enumerator_id,
                        'survey_id' => $request->survey_id,
                        'organization_id' => $request->ids[$i],
                    );

                    $this->enumeratorAssign->insert($data);
                }
            }


            DB::commit();
            session()->flash('success', 'Enumerator Assigned successfully');
            return redirect(route('enumeratorassign.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('enumeratorassign.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $survey = $this->surveyRepository->findById($id);
            if ($survey) {
                return view('backend.enumeratorassign.show', compact('survey'));
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {

        $id = (int)$id;
        try {
            $enumeratorassign = $this->enumeratorAssignRepository->findById($id);
            if ($enumeratorassign) {
                $this->enumeratorAssign->where('id', $id)->delete();
                $enumeratorassign->delete();
                session()->flash('success', 'Unassign Sucessful');
                return back();
            } else {
                session()->flash('error', 'Error Occurs!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    //    public function add(Request $request){
    ////        dd($request->all());
    //        DB::beginTransaction();
    //        try {
    //            $value=$request->all();
    //            if ($request->has('ids') && $request->ids != null && $request->has('enumerator_id') && $request->enumerator_id != null &&  $request->has('survey_id') && $request->survey_id != null)
    //            {
    //                    for ($i = 0; $i < count($request->ids); $i++) {
    //                        $data = array(
    //                            'emitter_id' => $request->enumerator_id,
    //                            'survey_id' => $request->survey_id,
    //                            'organization_id' => $request->ids[$i],
    //                        );
    //                        $this->enumeratorAssign->insert($data);
    //                    }
    //
    //                DB::commit();
    //                session()->flash('success', 'Enumeratior Assigned successfully');
    //                return redirect(route('enumeratorassign.index'));
    //            } else {
    //                DB::rollBack();
    //                session()->flash('error', 'could not be created!');
    //                return redirect(route('enumeratorassign.index'));
    //            }
    //
    //        } catch (\Exception $e) {
    //            DB::rollBack();
    //            $e = $e->getMessage();
    //            session()->flash('error', 'Exception : ' . $e);
    //            return redirect(route('emitter.index'));
    //        }
    //
    //    }
}
