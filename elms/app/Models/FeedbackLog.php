<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackLog extends Model
{
    use HasFactory;

    protected $fillable = ['remarks', 'status', 'enumerator_assign_id'];

}
