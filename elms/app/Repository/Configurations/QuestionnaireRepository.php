<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\Questionnaire;

class QuestionnaireRepository
{

    /**
     * @var Questionnaire
     */
    private $model;

    public function __construct(Questionnaire $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $questionnaires = $this->model->orderBy('file_name', 'ASC')->get();
        return $questionnaires;
    }
    public function findById($id)
    {
        $questionnaire = $this->model->find($id);
        return $questionnaire;
    }
}