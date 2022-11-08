<?php

namespace App\Models\Roles;

use App\Models\User;
use App\Models\Roles\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGroup extends Model
{
    use HasFactory;

    protected $fillable = ['group_name', 'group_details'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function user_roles()
    {
        return $this->hasMany(UserRole::class);
    }
}
