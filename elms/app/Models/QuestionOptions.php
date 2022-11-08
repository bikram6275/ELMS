<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class QuestionOptions extends Model
{
    use HasFactory;
    protected $fillable=['parent_id','qsn_id','option_number','option_name','option_order','option_type','options','remarks'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function children(){
        return $this->hasMany(QuestionOptions::class,'parent_id');
    }
}
