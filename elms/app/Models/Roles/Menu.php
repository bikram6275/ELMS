<?php

namespace App\Models\Roles;

use App\Models\Roles\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id', 'menu_name', 'menu_controller', 'menu_link', 'menu_css',
        'menu_icon', 'menu_status', 'menu_order'
    ];

    public $timestamps = false;

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function viewAllowded()
    {
        return $this->hasMany(UserRole::class, 'menu_id', 'id')
            ->where('user_group_id', Auth::user()->user_group_id)
            ->where('allow_view', 1);
    }

    public static function getMenu($id)
    {

        if (Auth::user()->user_group_id == 1) {
            $result = DB::table('menus')
                ->where('parent_id', $id)->where('menu_status', 1)
                ->orderBy('menu_order', 'ASC')
                ->get();
        } else {
            $result = DB::table('menus')->select('menus.*')
                ->join('user_roles', 'menus.id', '=', 'user_roles.menu_id')
                ->where('parent_id', $id)
                ->where('menu_status', 1)
                ->where('allow_view', 1)
                ->where('user_group_id', Auth::user()->user_group_id)
                ->orderBy('menu_order', 'ASC')
                ->get();
        }
        return $result;
    }
    public static function getMenus()
    {
        return $result = DB::table('menus')->select('menus.*')
            ->join('user_roles', 'menus.id', '=', 'user_roles.menu_id')
            ->where('parent_id', 0)
            ->where('menu_status', 1)
            ->where('allow_view', 1)
            ->where('user_group_id', Auth::user()->user_group_id)
            ->orderBy('menu_order', 'ASC')
            ->get();
    }

    public static function getAllowdedMenu()
    {
        return Menu::with(['children' => function ($q) {
            $q->whereHas('viewAllowded')
            ->orderBy('menu_order');
        }])
            ->whereHas('viewAllowded')
            ->where('parent_id', 0)
            ->orderBy('menu_order')
            ->get();
    }
}
