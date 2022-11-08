<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Configuration\Designation;
use App\Http\Requests\Users\UserAddRequest;
use App\Http\Requests\Users\PasswordRequest;
use App\Repository\Roles\UserGroupRepository;
use App\Http\Requests\Users\ProfilepicRequest;
use App\Http\Requests\Users\UserUpdateRequest;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Designation
     */
    private $designation;
    /**
     * @var UserGroupRepository
     */
    private $userGroupRepository;
    /**
     * @var User
     */
    private $user;

    public function __construct(UserRepository $userRepository, Designation $designation, UserGroupRepository $userGroupRepository, User $user)
    {

        $this->userRepository = $userRepository;
        $this->designation = $designation;
        $this->userGroupRepository = $userGroupRepository;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->all();
        $designationList = $this->designation->all();
        $groupList = $this->userGroupRepository->groupList();

        return view('backend.users.index', compact('users', 'designationList', 'groupList'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddRequest $request)
    {
        try {
            $password = str_random(6);
            $request['password'] = bcrypt($password);
            if (!empty($request->file('avatar_image'))) {
                $userAvatar = $request->file('avatar_image');
                $avatarExtension = $userAvatar->getClientOriginalExtension();
                $userAvatarName = 'profile' . time() . '.' . strtolower($avatarExtension);
                $request['user_image'] = $userAvatarName;
                $avatarImageSuccess = true;
            }

            $user = $this->user->create($request->all());
            if ($user) {
                if (isset($avatarImageSuccess)) {
                    Storage::putFileAs('public/uploads/users/images/profilePic', $userAvatar, $userAvatarName);
                    Image::make(storage_path() . '/app/public/uploads/users/images/profilePic/' . $userAvatarName)->resize(128, 128)->save();
                }
                if ($user)
                    Mail::send('backend.email.addUser', ['userName' => $request->name, 'password' => $password], function ($m) use ($request) {
                        $m->to($request->email)->subject('User Registration Information');
                    });
                session()->flash('success', 'User Successfully Created!');
                return back();
            } else {
                session()->flash('success', 'User could not be Create!');
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->userRepository->findById($id);
            if ($edits->count() > 0) {
                $users = $this->userRepository->all();
                $designationList = Designation::select('id', 'designation_name')->get();
                $groupList = $this->userGroupRepository->groupList();

                return view('backend.users.index', compact('users', 'edits', 'designationList', 'groupList'));
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $user = $this->userRepository->findById($id);
            $oldValue = $this->userRepository->findById($id);

            if ($user) {
                if (!empty($request->file('avatar_image'))) {
                    $userAvatar = $request->file('avatar_image');
                    $avatarExtension = $userAvatar->getClientOriginalExtension();
                    $userAvatarName = 'profile' . time() . '.' . strtolower($avatarExtension);
                    $request['user_image'] = $userAvatarName;
                    $avatarImageSuccess = true;
                }

                $update = $user->fill($request->all())->save();
                if ($update) {
                    if (isset($avatarImageSuccess)) {
                        if ($oldValue->user_image != null)
                            @unlink(storage_path() . '/app/public/uploads/users/images/profilePic/' . $oldValue->user_image);

                        Storage::putFileAs('public/uploads/users/images/profilePic', $userAvatar, $userAvatarName);
                        Image::make(storage_path() . '/app/public/uploads/users/images/profilePic/' . $userAvatarName)->resize(128, 128)->save();
                    }

                    session()->flash('success', 'User Successfully updated!');
                    return redirect(route('user.index'));
                } else {
                    session()->flash('error', 'User could not be update!');
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $user = $this->userRepository->findById($id);
            if ($user) {
                $user->delete();
                @unlink(storage_path() . '/app/public/uploads/users/images/profilePic/' . $user->user_image);
                session()->flash('success', 'User successfully deleted!');
                return back();
            } else {
                session()->flash('error', 'User could not be delete!');
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
            $user = $this->userRepository->findById($id);
            if ($user->user_status == 'inactive') {
                $user->user_status = 'active';
                $user->save();
                session()->flash('success', 'User Successfully Activated!');
                return back();
            }
            $user->user_status = 'inactive';
            $user->save();
            session()->flash('success', 'User Successfully Deactivated!');
            return back();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return back();
        }
    }

    public function profile()
    {

        $loginDetails = $this->userRepository->userLoginDetails();
        $lastLogin = DB::table('login_logs')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->skip(1)->take(1)->value('created_at');
        $user = Auth::user();
        return view('backend.users.profile', compact('user', 'lastLogin', 'loginDetails'));
    }

    public function password(PasswordRequest $request)
    {
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

    public function profilePic(ProfilepicRequest $request)
    {
        $user = Auth::user();
        if (!empty($request->file('user_image'))) {
            $userPicture = $request->file('user_image');
            $extension = $userPicture->getClientOriginalExtension();
            $userAvatar = 'profile' . time() . '.' . strtolower($extension);
            $request['user_image'] = $userAvatar;
            $avatarImageSuccess = true;
        }
        if (isset($avatarImageSuccess)) {
            if ($user->user_image != null) {
                @unlink(storage_path() . '/app/public/uploads/users/images/profilePic/' . $user->user_image);
            }
            Storage::putFileAs('public/uploads/users/images/profilePic', $userPicture, $userAvatar);
            Image::make(storage_path() . '/app/public/uploads/users/images/profilePic/' . $userAvatar)->resize(128, 128)->save();
            $user->user_image = $userAvatar;
            $user->save();
        }
        return back();
    }
}
