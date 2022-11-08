<?php

namespace App\Models;

use App\Models\Roles\UserGroup;
use Illuminate\Notifications\Notifiable;
use App\Models\Configuration\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'designation_id',
        'user_group_id',
        'user_image',
        'user_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function user_group()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id', 'id');
    }

    public function supervisor()
    {
        return $this->hasOne(CoordinatorSupervisor::class, 'supervisor_id','id');
    }
     public function coordinators()
     {
         return $this->hasMany(CoordinatorSupervisor::class,'coordinator_id','id');
     }

     public function emitters()
     {
         return $this->hasMany(Emitter::class,'supervisor_id','id');
     }
  
}
