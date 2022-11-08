<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationProfilepicRrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Users\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Organization\Organization;
use App\Repository\Organization\OrganizationRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{

    /**
     * @var Organization
     */
    private $user;
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;

    public function __construct(Organization $user , OrganizationRepository $organizationRepository)
    {

        $this->user = $user;
        $this->organizationRepository = $organizationRepository;
    }
    public function profile(){

        $user = Auth::guard('orgs')->user();
        return view('backend.organization.profile', compact('user'));
    }

    public function password(Request $request){
        if (Hash::check($request->input('old'), Auth::user()->password)) {
            $id = Auth::user()->id;
            $data = $this->user->find($id);
            if ($data) {
                $request['password'] = Hash::make($request->input('password'));
                $data->fill($request->all())->save();
                session()->flash('success', 'Password was changed successfully!');
                return redirect()->back();
            }
            session()->flash('error', 'Error Occoured!!!! Something is not right!');
            return redirect()->back()->withInput();
        }
        session()->flash('error', 'Error Occoured!!!! Old password incorrect!');
        return redirect()->back()->withInput();
    }

    public function profilePic(OrganizationProfilepicRrequest $request)
    {
        $user = Auth::user();
        if (!empty($request->file('org_image'))) {
            $orgPicture = $request->file('org_image');
            $extension = $orgPicture->getClientOriginalExtension();
            $orgAvatar = 'logo' . time() . '.' . strtolower($extension);
            $request['org_image'] = $orgAvatar;
            $avatarImageSuccess = true;
        }
        if (isset($avatarImageSuccess)) {
            if ($user->org_image != null) {
                @unlink(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $user->org_image);
            }
            Storage::putFileAs('public/uploads/organization/images/organizationPic', $orgPicture, $orgAvatar);
            Image::make(storage_path() . '/app/public/uploads/organization/images/organizationPic/' . $orgAvatar)->resize(128, 128)->save();
            $user->org_image = $orgAvatar;
            $user->save();
        }
        return back();
    }

}
