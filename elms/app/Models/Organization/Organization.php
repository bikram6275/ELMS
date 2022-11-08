<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Configuration\District;
use App\Models\Configuration\EconomicSector;
use  App\Models\Configuration\Municipality;
use  App\Models\Configuration\Pradesh;
use  App\Models\Enumeratorassign\EnumeratorAssign;
use  App\Models\Emitter;
use  App\Models\Survey\Survey;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class Organization extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "organizations";


    protected $fillable = [
        'org_name', 'pradesh_id', 'district_id', 'muni_id', 'ward_no', 'phone_no', 'email', 'fax', 'website', 'establish_date', 'name', 'password', 'user_status', 'org_image', 'detail', 'sector_id', 'pan_number', 'licensce_no', 'tole'
    ];

    protected $hidden = [
        'password', 'remember_token',
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

    public function enumeratorassign()
    {
        return $this->belongsTo(EnumeratorAssign::class, 'id', 'organization_id');
    }


    //For pivot relationship

    public function emitter()
    {
        return $this->belongsToMany(Emitter::class, 'enumeratorassign_pivot', 'organization_id', 'emitter_id');
    }
    //
    public function survey()
    {
        return $this->belongsToMany(Survey::class, 'enumeratorassign_pivot', 'organization_id', 'survey_id');
    }
    public  function  disable($o_id, $e_id, $s_id)
    {

        $d = EnumeratorAssign::where('organization_id', $o_id)->where('emitter_id', '<>', $e_id)->where('survey_id', $s_id)->get();

        if (!$d->isEmpty()) {
            return true;
        } else
            return false;
    }

    public function sector()
    {
        return $this->belongsTo(EconomicSector::class, 'sector_id', 'id');
    }
}
