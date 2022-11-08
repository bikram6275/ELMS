<?php

namespace App\Models\Logs;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLogs extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'log_in_date', 'log_in_device', 'log_in_ip'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
