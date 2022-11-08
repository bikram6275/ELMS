<?php

namespace App\Repository\Roles;

use App\Models\Roles\Menu;
use App\Models\Roles\UserRole;

class UserRolesRepository
{

    /**
     * @var UserRole
     */
    private $userRole;
    /**
     * @var Menu
     */
    private $menu;

    function __construct(UserRole $userRole, Menu $menu)
    {
        $this->userRole = $userRole;
        $this->menu = $menu;
    }
    public function copyMenu($group_id)
    {
        if ($group_id != 0) {
            $menus = $this->menu->all();
            foreach ($menus as $menu) {
                if ($this->checkMenu($group_id, $menu->id) == 0) {
                    $this->userRole
                        ->insert(
                            [
                                'user_group_id' => $group_id,
                                'menu_id' => $menu->id,
                                'allow_view' => '0',
                                'allow_add' => '0',
                                'allow_edit' => '0',
                                'allow_delete' => '0'
                            ]
                        );
                }
            }
        }
    }

    private function checkMenu($group_id, $menu_id)
    {
        return $this->userRole
            ->where('user_group_id', '=', $group_id)
            ->where('menu_id', '=', $menu_id)
            ->count();
    }

    public function changePermission($allowId, $id)
    {
        if ($allowId == 1) {
            $value = $this->userRole
                ->where('id', '=', $id)
                ->select('allow_view')->first();
            $this->userRole
                ->where('id', '=', $id)
                ->update(['allow_view' => ($value->allow_view == '1') ? '0' : '1']);
        } elseif ($allowId == 2) {
            $value = $this->userRole
                ->where('id', '=', $id)
                ->select('allow_add')->first();

            $this->userRole
                ->where('id', '=', $id)
                ->update(['allow_add' => ($value->allow_add == '1') ? '0' : '1']);
        } elseif ($allowId == 3) {
            $value = $this->userRole
                ->where('id', '=', $id)
                ->select('allow_edit')->first();

            $this->userRole
                ->where('id', '=', $id)
                ->update(['allow_edit' => ($value->allow_edit == '1') ? '0' : '1']);
        } else {
            $value = $this->userRole
                ->where('id', '=', $id)
                ->select('allow_delete')->first();

            $this->userRole
                ->where('id', '=', $id)
                ->update(['allow_delete' => ($value->allow_delete == '1') ? '0' : '1']);
        }
    }
}