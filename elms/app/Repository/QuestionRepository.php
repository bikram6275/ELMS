<?php

namespace App\Repository;

use App\Models\Questions;

class QuestionRepository
{

    /**
     * @var Questions
     */
    private $questions;

    public function __construct(Questions $questions)
    {
        $this->questions = $questions;
    }
    public function all()
    {
        $questions = $this->questions->where('qst_status','active')->orderBy('qsn_order', 'asc')->get();
        return $questions;
    }

    public function findById($id)
    {
        $questions = $this->questions->with(['questionOption','children.questionOption'])->find($id);
        return $questions;
    }
    public function parentQuestion()
    {
        $questions=$this->questions->where('parent_id',0)->where('qst_status','active')->orderBy('qsn_order','asc')->get();
        return $questions;
    }

    public function recentQuestion($qsn_id)
    {
        $questions = $this->questions->with(['questionOption','children.questionOption'])
        ->where('qst_status','active')
        ->where('id',$qsn_id)
        ->first();
        return $questions;
    }
    public function questions()
    {
        $questions = $this->questions->with(['questionOption','children.questionOption'])
        ->where('qst_status','active')
        ->where('parent_id',0)
        ->orderBy('qsn_order', 'asc')
        ->get();
        return $questions;
    }


    public function findchild($parent_id){
        $question=$this->questions->where('parent_id',$parent_id)->where('qst_status','active')->get();
        return $question;
    }

    public function apiQuestions()
    {
        $questions = $this->questions->where('qst_status','active')->where('parent_id',0)->orderBy('qsn_order', 'asc')->get();
        return $questions;
    }


    public function questionsWithAnswer($pivot_id)
    {
        $result = $this->questions->with(['questionOption','children.questionOption','children.answer'=>function($q) use ($pivot_id){
                $q->where('enumerator_assign_id',$pivot_id);
        },
        'answer'=>function($q1) use ($pivot_id){
            $q1->where('enumerator_assign_id',$pivot_id);
        }])
        ->where('qst_status','active')
        ->where('parent_id',0)
        ->orderBy('qsn_order', 'asc')
        ->get();
        return $result;
    }

    public function findByQuestionNumber($id)
    {
        $questions = $this->questions->where('qsn_number',$id)->first();
        return $questions;
    }

}
