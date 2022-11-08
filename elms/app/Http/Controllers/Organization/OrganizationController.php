<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Imports\OrganizationImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Organization\Organization;
use App\Repository\Configurations\PradeshRepository;
use App\Models\Employee\EmployeePreviousOrganization;
use App\Repository\Configurations\DistrictRepository;
use App\Http\Requests\Organization\OrganizationRequest;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\Configurations\MunicipalityRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;




class OrganizationController extends Controller
{
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;
    /**
     * @var Organization
     */
    private $organization;
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
     * @var EconomicSectorRepository
     */
    private $economicSectorRepository;
    /**
     * @var EmployeePreviousOrganization
     */
    private $employeePreviousOrganization;

    public function __construct(
        OrganizationRepository $organizationRepository,
        Organization $organization,
        PradeshRepository $pradeshRepository,
        DistrictRepository $districtRepository,
        MunicipalityRepository $municipalityRepository,
        EconomicSectorRepository $economicSectorRepository,
        EmployeePreviousOrganization $employeePreviousOrganization
    ) {


        $this->organizationRepository = $organizationRepository;
        $this->organization = $organization;
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->municipalityRepository = $municipalityRepository;
        $this->economicSectorRepository = $economicSectorRepository;
        $this->employeePreviousOrganization = $employeePreviousOrganization;
    }

    public function index(Request $request)
    {
        $organizations = $this->organizationRepository->all($request);
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        return view('backend.organization.index', compact('organizations','pradeshes','districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pradeshes = $this->pradeshRepository->all();
        $districts = $this->districtRepository->all();
        $municipalities = $this->municipalityRepository->all();
        $parents = $this->economicSectorRepository->parents();
        return view('backend.organization.create', compact('pradeshes', 'districts', 'municipalities', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {

        try {

            $value = $request->all();

            if (!empty($request->file('org_image'))) {
                $orgAvatar = $request->file('org_image');
                $avatarExtension = $orgAvatar->getClientOriginalExtension();
                $orgAvatarName = 'logo' . time() . '.' . strtolower($avatarExtension);
                $value['org_image'] = $orgAvatarName;
                $avatarImageSuccess = true;
            }
            $value['password'] = bcrypt($request->password);
            $create = $this->organization->create($value);
            if ($create) {

                if (isset($avatarImageSuccess)) {
                    Storage::putFileAs('public/uploads/organization/images/organizationPic', $orgAvatar, $orgAvatarName);
                    Image::make(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $orgAvatarName)->resize(128, 128)->save();
                }
                Mail::send('backend.email.orgsUser', ['password' => $request->password], function ($m) use ($request) {
                    $m->to($request->email)->subject('User Registration Information');
                });
                session()->flash('success', 'Organization successfully added');
                return redirect(route('organization.index'));
            } else {
                session()->flash('error', 'could not be created!');
                return redirect(route('organization.index'));
            }
        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return redirect(route('organization.index'));
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
            $organization = $this->organizationRepository->findById($id);
            if ($organization) {
                return view('backend.organization.show', compact('organization'));
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
    public function edit($id)
    {

        try {
            $id = (int)$id;
            $edits = $this->organizationRepository->findById($id);
            $pradeshes = $this->pradeshRepository->all();
            $districts = $this->districtRepository->findDistrict($edits->pradesh_id);
            $municipalities = $this->municipalityRepository->findMunicipality($edits->district_id);
            $parents = $this->economicSectorRepository->parents();
            if ($edits->count() > 0) {
                $organizations = $this->organization->all();
                return view('backend.organization.edit', compact('edits', 'pradeshes', 'districts', 'municipalities', 'organizations', 'parents'));
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
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        try {
            $organization = $this->organizationRepository->findById($id);
            $oldValue = $this->organizationRepository->findById($id);
            if ($organization) {
                $value = $request->all();
                if (!empty($request->file('org_image'))) {
                    $orgAvatar = $request->file('org_image');
                    $avatarExtension = $orgAvatar->getClientOriginalExtension();
                    $orgAvatarName = 'logo' . time() . '.' . strtolower($avatarExtension);
                    $value['org_image'] = $orgAvatarName;
                    $avatarImageSuccess = true;
                }
                $update = $value['password'] = bcrypt($request->password);
                $organization->fill($value)->save();

                if ($update) {
                    if (isset($avatarImageSuccess)) {
                        if ($oldValue->org_image != null)
                            @unlink(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $oldValue->org_image);

                        Storage::putFileAs('public/uploads/organization/images/organizationPic', $orgAvatar, $orgAvatarName);
                        Image::make(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $orgAvatarName)->resize(128, 128)->save();
                    }

                    session()->flash('success', 'Organization updated successfully!');
                    return redirect(route('organization.index'));
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
            $organization = $this->organizationRepository->findById($id);
            if ($organization) {
                $organization->delete();
                @unlink(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $organization->org_image);
                session()->flash('success', 'Organization successfully deleted!');
                return back();
            } else {
                session()->flash('error', 'Organization could not be delete!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function status($id)
    {
        try {
            $id = (int)$id;
            $organization = $this->organizationRepository->findById($id);
            if ($organization->user_status == 'inactive') {
                $organization->user_status = 'active';
                $organization->save();
                session()->flash('success', 'Organization Successfully Activated!');
                return back();
            }
            $organization->user_status = 'inactive';
            $organization->save();
            session()->flash('success', 'Organization Successfully Deactivated!');
            return back();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return back();
        }
    }


    public function getDistrict($pradesh_id)
    {

        $result = $this->districtRepository->findDistrict($pradesh_id);
        //        dd($result);
        return response()->json($result);
    }

    public function getMunicipality($district_id)
    {
        $result = $this->municipalityRepository->findMunicipality($district_id);
        //        dd($result);
        return response()->json($result);
    }
    public function remove($id)
    {
        $preOrg = $this->employeePreviousOrganization->where('id', $id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function getImport()
    {
        return view('backend.organization.import');
    }

    public function storeImport(Request $request)
    {
        Excel::import(new OrganizationImport, $request->file('file')->store('temp'));
        return back();
    }
}
