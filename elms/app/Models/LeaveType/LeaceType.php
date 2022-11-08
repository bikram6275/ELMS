<?php

namespace App\Models\LeaveType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaceType extends Model
{
    use HasFactory;
    protected $table = "leave_type";
    protected $fillable = [
        'name'
    ];
}

