<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Models\Roles\UserGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\GroupRequest;
use App\Repository\Roles\UserGroupRepository;

class UserGroupController extends Controller
{
    /**
     * @var UserGroupRepository
     */
    private $userGroupRepository;
    /**
     * @var UserGroup
     */
    private $userGroup;

    public function __construct(UserGroupRepository $userGroupRepository, UserGroup $userGroup)
    {
        
        $this->userGroupRepository = $userGroupRepository;
        $this->userGroup = $userGroup;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->userGroupRepository->all();
        return view('backend.roles.groups.index', compact('groups'));
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
    public function store(GroupRequest $request)
    {
        try {
            $create = $this->userGroup->create($request->all());

            if ($create) {
                session()->flash('success', 'Group successfully created');
                return back();
            } else {
                session()->flash('error', 'Group couldnot be created');
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
            $edits = $this->userGroupRepository->findById($id);

            if (!empty($edits)) {
                $groups = $this->userGroupRepository->all();
                return view('backend.roles.groups.index', compact('groups', 'edits'));
            } else {
                session()->flash('error', 'Id could not be obtained');
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
    public function update(GroupRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $menu = $this->userGroupRepository->findById($id);
            if ($menu) {
                $menu->fill($request->all())->save();
                session()->flash('success', 'Group updated successfully');

                return redirect(route('group.index'));
            } else {

                session()->flash('error', 'No record with given id');
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
            $roles = DB::table('users')->where('user_group_id', $id)->select('id')->get();

            if (count($roles) == '') {
                if ($this->userGroup->destroy($id)) {
                    session()->flash('success', 'Group successfully deleted');
                    return back();
                } else {
                    session()->flash('error', 'Group could not be deleted');
                    return back();
                }
            } else {
                session()->flash('warning', 'Group could not be deleted');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
