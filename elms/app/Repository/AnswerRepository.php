<?php

namespace App\Repository;

use App\Models\Answers;

class AnswerRepository
{

    /**
     * @var Answers
     */
    private $answer;

    public function __construct(Answers $answer)
    {
        $this->answer = $answer;
    }
    public function all()
    {
        $answer = $this->answer->orderBy('id', 'asc')->get();
        return $answer;
    }

    public function findById($id)
    {
        $answer = $this->answer->find($id);
        return $answer;
    }

    public function findByQsnId($qsn_id, $pivot_id)
    {
        $result = $this->answer->where('enumerator_assign_id', $pivot_id)->where('qsn_id', $qsn_id)->first();
        return $result;
    }
    public function answers($pivot_id)
    {
        $result = $this->answer->where('enumerator_assign_id', $pivot_id)->get()->groupBy('qsn_id');
        return $result;
    }
    public function findByQsn($qsn_id)
    {
        $result = $this->answer->where('qsn_id', $qsn_id)->get();
        return $result;
    }

    public function findQuestion5Answer(){
return 'hello';
    }
}
