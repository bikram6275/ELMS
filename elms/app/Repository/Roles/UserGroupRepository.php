<?php

namespace App\Repository\Roles;

use App\Models\Roles\UserGroup;

class UserGroupRepository
{

    /**
     * @var UserGroup
     */
    private $userGroup;

    public function __construct(UserGroup $userGroup)
    {
        $this->userGroup = $userGroup;
    }

    public function all()
    {
        $groups = $this->userGroup->all();
        return $groups;
    }

    public function groupList()
    {
        $groups = $this->userGroup
            ->select('id', 'group_name')
            ->orderBy('id', 'DESC')
            ->get();
        return $groups;
    }

    public function findById($id)
    {
        $group = $this->userGroup->find($id);
        return $group;
    }
}