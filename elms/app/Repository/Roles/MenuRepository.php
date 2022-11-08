<?php

namespace App\Repository\Roles;

use App\Models\Roles\Menu;
use Illuminate\Support\Facades\DB;

class MenuRepository
{
    /**
     * @var Menu
     */
    private $menu;

    public function __construct(Menu $menu)
    {

        $this->menu = $menu;
    }

    public function all()
    {
        $menus = $this->menu->all();
        return $menus;
    }

    public function parentList()
    {
        $menus = $this->menu
            ->select('id', 'menu_name')
            ->orderBy('id', 'DESC')
            ->get();
        return $menus;
    }

    public function findById($id)
    {
        $menu = $this->menu->find($id);
        return $menu;
    }

    public function getAccessMenu($id, $group_id)
    {
        $result = DB::table('menus')
        ->join('user_roles', 'menus.id', '=', 'user_roles.menu_id')
        ->where('parent_id', $id)
            ->where('menu_status', 1)
            ->where('user_group_id', $group_id)
            ->select(
                'user_roles.id as group_role_id',
                'user_group_id',
                'menu_id',
                'allow_view',
                'allow_add',
                'allow_edit',
                'allow_delete',
                'menus.*'
            )
            ->orderBy('menu_order', 'ASC')
            ->get();
        return  $result;
    }

    public static function getMenuLink($controllerName)
    {

        $result = DB::table('menus')->select('menu_link', 'parent_id')->where('menu_controller', $controllerName)->first();
        return  $result;
    }
}