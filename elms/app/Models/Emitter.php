<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Models\Configuration\Pradesh;
use App\Models\Configuration\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Organization\Organization;
use App\Models\Configuration\Municipality;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Emitter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'user_status', 'phone_no', 'remember_token', 'pradesh_id', 'district_id', 'muni_id', 'ward_no','supervisor_id'
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
    public function pradesh()
    {
        return $this->belongsTo(Pradesh::class, 'pradesh_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'muni_id', 'id');
    }

    //    public function organizations()
    //    {
    //        return $this->belongsToMany(Organization::class);
    //    }

    public function assigned($id)
    {
        // $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', null)->count();
        $a =  EnumeratorAssign::where('emitter_id', $id)->count();
        return $a;
    }
    public function inProgress($id)
    {
        $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', '<>', null)->where('finish_date', null)->count();
        return $a;
    }
    public function complete($id)
    {
        $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', '<>', null)->where('finish_date', '<>', null)->count();
        return $a;
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url('/emitters/emitter/reset-password?token='.$token);

        $this->notify(new ResetPasswordNotification($url));
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id','id');
    }

    public function survey()
    {
        return $this->hasMany(EnumeratorAssign::class,'emitter_id','id');
    }
}
