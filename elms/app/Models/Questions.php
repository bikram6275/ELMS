<?php

namespace App\Models;

use App\Models\Answers;
use App\Models\QuestionOptions;
use App\Models\TechnologyDetails;
use Illuminate\Database\Eloquent\Model;
use App\Repository\QuestionOptionsRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id', 'qsn_number', 'qsn_name', 'ans_type', 'qst_status', 'required', 'instruction', 'qsn_modify', 'qsn_order'];

    public function questionOption()
    {
        return $this->hasMany(QuestionOptions::class, 'qsn_id', 'id');
    }

    public function orgQuestionAnswer($pivot_id, $id)
    {
        $answer = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', $id)->get();
        foreach ($answer as $key => $a) {
            if ($a->question->ans_type == 'multiple_input') {
                $a->answer = json_decode($a->answer);
            }
            if($a->qsn_id==20){
                $options = QuestionOptionsRepository::find($a->qsn_opt_id);
                if($options->option_name == 'Yes')
                {
                    $a->other_occup = OtherOccupationDetails::where('enumerator_assign_id',$pivot_id)->get();
                }
            }
            $qsn = $this->where('qsn_number','9')->first();
            if($a->qsn_id == $qsn->id ){
                $sub_qsn = $this->where('qsn_number','9.1')->first();
                $a->conditional_answer = Answers::where('enumerator_assign_id', $pivot_id)->where('qsn_id', $sub_qsn->id)->get();
            }
            $qsn17 = $this->where('qsn_number','17')->first();
            if($a->qsn_id == $qsn17->id ){
                $sub_qsn = $this->where('qsn_number','17.1')->first();
                $a->conditional_answer = TechnologyDetails::with(['sector'=>function($query){$query->select('id','parent_id');}])->where('enumerator_assign_id', $pivot_id)->get();
            }

            $qsn18 = $this->where('qsn_number','18')->first();
            if($a->qsn_id == $qsn18->id ){
                $a->conditional_answer = BusinessFuturePlan::where('enumerator_assign_id', $pivot_id)->get();
            }
        }
        return $answer;
    }
    public function children()
    {
        return $this->hasMany(Questions::class, 'parent_id');
    }
    public function answer(){
        return $this->hasMany(Answers::class,'qsn_id');
    }

    public function subQuestionWithAnswer($id, $enumerator_assign_id)
    {
        // return $enumerator_assign_id;
        $c = fn($q) => $q->where('enumerator_assign_id', $enumerator_assign_id)->get();
        $sub_questions = Questions::where('parent_id',$id)->with(['answer'=>$c])->with('questionOption')->get();
        foreach ($sub_questions as $key => $a) {
            
               foreach($a->answer as $b)
               {
                   $b->answer = json_decode($b->answer);
               }
        }
        return $sub_questions;
    }
}
