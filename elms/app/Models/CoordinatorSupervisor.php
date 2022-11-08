<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordinatorSupervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'coordinator_id','supervisor_id','survey_id'
    ];

    public function coordinator()
    {
        return $this->belongsTo(User::class,'coordinator_id','id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id','id');
    }
}
