<?php

namespace App\Http\Controllers\Roles;

use App\Models\Roles\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\MenuRequest;
use App\Repository\Roles\MenuRepository;

class MenuController extends Controller
{

    /**
     * @var MenuRepository
     */
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {

        $this->menuRepository = $menuRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->menuRepository->all();
        $parentList = $this->menuRepository->parentList();
        return view('backend.roles.menus.index', compact('menus', 'parentList'));
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
    public function store(MenuRequest $request)
    {
        try {
            if ($request['parent_id'] == null) {
                $request['parent_id'] = 0;
            }
            $create = Menu::create($request->all());
            if ($create) {
                session()->flash('success', 'Menu successfully created');
                return back();
            } else {
                session()->flash('error', 'Menu could not be created');
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
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->menuRepository->findById($id);
            if (!empty($edits)) {
                $parentList = $this->menuRepository->parentList();
                $parentList[0]['id'] = 0;
                $parentList[0]['menu_name'] = 'Parent';
                $menus = $this->menuRepository->all();

                return view('backend.roles.menus.index', compact('menus', 'parentList', 'edits'));
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
    public function update(MenuRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $menu = $this->menuRepository->findById($id);
            if ($menu) {
                $menu->fill($request->all())->save();
                session()->flash('success', 'Menu updated successfully');

                return redirect(route('menu.index'));
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
            $menu = Menu::find($id);
            $roles = DB::table('user_roles')->where('menu_id', $menu->id)->select('id')->get();
            $menus = DB::table('menus')->where('parent_id', $menu->id)->select('id')->get();

            if (count($roles) == '' && count($menus) == '') {
                if ($menu->destroy($id)) {
                    session()->flash('success', 'Menu successfully deleted');
                    return back();
                } else {
                    session()->flash('error', 'Menu could not be deleted');
                    return back();
                }
            }
            session()->flash('warning', 'Unable to delete');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function changeStatus($id)
    {

        try {
            $id = (int)$id;
            $menu = $this->menuRepository->findById($id);
            if ($menu->menu_status == '0') {
                $menu->menu_status = '1';
                $menu->save();
                session()->flash('success', 'Menu Successfully Activated');
                return back();
            }
            $menu->menu_status = '0';
            $menu->save();
            session()->flash('success', 'Menu Successfully Deactivated');
            return back();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return back();
        }
    }
}
