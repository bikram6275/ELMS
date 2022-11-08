<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSkills extends Model
{
    use HasFactory;

    protected $fillable=['enumerator_assign_id','skill','formally_trained','formally_untrained'];
}
