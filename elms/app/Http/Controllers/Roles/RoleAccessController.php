<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Models\Roles\UserRole;
use App\Http\Controllers\Controller;
use App\Repository\Roles\MenuRepository;
use App\Repository\Roles\UserGroupRepository;
use App\Repository\Roles\UserRolesRepository;

class RoleAccessController extends Controller
{
    /**
     * @var UserGroupRepository
     */
    private $userGroupRepository;
    /**
     * @var MenuRepository
     */
    private $menuRepository;
    /**
     * @var UserRole
     */
    private $userRole;
    /**
     * @var UserRolesRepository
     */
    private $userRolesRepository;

    public function __construct(
        UserGroupRepository $userGroupRepository,
        MenuRepository $menuRepository,
        UserRole $userRole,
        UserRolesRepository $userRolesRepository
    ) {
        
        $this->userGroupRepository = $userGroupRepository;
        $this->menuRepository = $menuRepository;
        $this->userRole = $userRole;
        $this->userRolesRepository = $userRolesRepository;
    }

    public function index(Request $request)
    {
        $groupList = $this->userGroupRepository->groupList();
        if ($request->has('group_id')) {
            $group_id = $request->get('group_id');
        } else {
            $group_id = 0;
        }

        if ($request->has('group_id')) {
            $menus = $this->menuRepository->getAccessMenu(0, $group_id);
        } else {
            $menus = [];
        }
        $this->userRolesRepository->copyMenu($group_id);
        $menuRepo = $this->menuRepository;
        return view('backend.roles.roleAccess', compact('menus', 'groupList', 'menuRepo'));
    }

    public function changeAccess($allowId, $id)
    {
        $this->userRolesRepository->changePermission($allowId, $id);
    }
}
