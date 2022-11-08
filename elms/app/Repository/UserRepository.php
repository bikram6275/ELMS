<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Logs\LoginLogs;


class UserRepository
{

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function all()
    {
        $users = $this->user->orderBy('name', 'asc')->get();
        return $users;
    }

    public function userList()
    {
        $users = $this->user
            ->select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get();
        return $users;
    }

    public function findById($id)
    {
        $user = $this->user->find($id);
        return $user;
    }

    public function findByUser($id)
    {
        return $this->user->select('id', 'name')->find($id);
    }

    public function userLoginDetails()
    {
        $loginDetails = LoginLogs::orderBy('id', 'DESC')->limit(5)->get();
        return $loginDetails;
    }
}