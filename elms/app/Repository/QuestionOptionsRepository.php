<?php

namespace App\Repository;

use App\Models\QuestionOptions;

class QuestionOptionsRepository
{

    /**
     * @var QuestionOptions
     */
    private $question_options;

    public function __construct(QuestionOptions $question_options)
    {
        $this->question_options = $question_options;
    }
    public function all()
    {
        $question_options = $this->question_options->orderBy('id', 'asc')->get();
        return $question_options;
    }

    public  function findById($id)
    {
        $question_options = $this->question_options->find($id);
        return $question_options;
    }
    public function findByQsnId($qsn_id)
    {
        $data=$this->question_options->where('qsn_id',$qsn_id)->get();
        return $data;
    }

    #static function to use in model
    public static function find($id)
    {
        return QuestionOptions::find($id);
    }

}
