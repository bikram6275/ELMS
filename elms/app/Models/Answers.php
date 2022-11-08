<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Questions;
use App\Models\QuestionOptions;
use App\Scopes\AnswerScope;

class Answers extends Model
{
    use HasFactory;
    protected $fillable = ['enumerator_assign_id', 'qsn_id', 'answer', 'qsn_opt_id', 'other_answer', 'other_values','Deleted'];
    
    protected static function booted()
    {
        static::addGlobalScope(new AnswerScope);
    }

    public function question()
    {
        return $this->belongsTo(Questions::class,'qsn_id','id');
    }
    public function questionOption()
    {
       return $this->belongsTo(QuestionOptions::class,'qsn_opt_id');
    }
}
