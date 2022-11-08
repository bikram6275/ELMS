<?php

namespace App\Http\Controllers\Emitter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emitter;
use App\Repository\Emitter\EmitterRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * @var Emitter
     */
    private $user;
    /**
     * @var EmitterRepository
     */
    private $emitterRepository;

    public function __construct(Emitter $user, EmitterRepository $emitterRepository)
    {

        $this->user = $user;
        $this->emitterRepository = $emitterRepository;
    }
    public function profile(){

        $user = Auth::guard('emitter')->user();
        return view('emitter.profile', compact('user'));
    }

    public function password(Request $request){
        if (Hash::check($request->input('old'), Auth::guard('emitter')->user()->password)) {
            $id = Auth::guard('emitter')->user()->id;
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





}
