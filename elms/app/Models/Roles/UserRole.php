<?php

namespace App\Models\Roles;

use App\Models\Roles\UserGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['user_group_id', 'menu_id', 'allow_view', 'allow_add', 'allow_edit', 'allow_delete',];

    public function user_group()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id', 'id');
    }
}
