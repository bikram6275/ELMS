<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\QuestionOptions;
use App\Models\Questions;
use App\Repository\DataRepository;
use App\Repository\QuestionOptionsRepository;
use App\Repository\QuestionRepository;
use App\Repository\Survey\SurveyRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $questionRepository;
    private $dataRepository;
    private $questionOptionsRepository;

    protected $survey;

    public function __construct(QuestionRepository $questionRepository, DataRepository $dataRepository, QuestionOptionsRepository $questionOptionsRepository, SurveyRepository $survey)
    {

        $this->questionRepository=$questionRepository;
        $this->dataRepository=$dataRepository;
        $this->questionOptionsRepository=$questionOptionsRepository;

        $this->survey = $survey;
    }

    public function index(Request $request)
    {
        $questions= $this->questionRepository->all();
        return view('question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_qsn=$this->questionRepository->parentQuestion();
         $ansTypes= $this->dataRepository->ansType();
         $optionType= $this->dataRepository->optionType();
         $survey = $this->survey->all();
        return view('question.add',compact('ansTypes','optionType','parent_qsn','survey'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        try {
            $questionDetails= $request->all();
            if(!isset($questionDetails['qsn']['parent_id'] ) || $questionDetails['qsn']['parent_id']==null ){
                $questionDetails['qsn']['parent_id']=0;
            }
            $create= Questions::create($questionDetails['qsn'])->id;
            if($questionDetails['qsn']['ans_type']=='radio' || $questionDetails['qsn']['ans_type']=='checkbox' || $questionDetails['qsn']['ans_type']=='multiple_input' || $questionDetails['qsn']['ans_type']=='cond_radio' || $questionDetails['qsn']['ans_type']=='range'){

                foreach ($questionDetails['option'] as $key => $value) {
                    $value['qsn_id']=$create;
                    QuestionOptions::create($value);
                }
            }
            if ($create) {
                session()->flash('success', 'Question successfully created!');
              return redirect(route('question.index'));
            } else {
                session()->flash('error', 'Question could not be created!');
              return redirect(route('question.index'));
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->questionRepository->findById($id);
            if ($edits->count() > 0) {
                $ansTypes= $this->dataRepository->ansType();
                $optionType = $this->dataRepository->optionType();
               $parent_qsn=$this->questionRepository->parentQuestion();
                return view('question.edit', compact('edits','ansTypes','optionType','parent_qsn'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $questionDetails=$request->all();
            if(!isset($questionDetails['qsn']['parent_id'] ) || $questionDetails['qsn']['parent_id']==null ){
                $questionDetails['qsn']['parent_id']=0;
            }
            $questions = $this->questionRepository->findById($id);
            $questionOptions=$this->questionOptionsRepository->findByQsnId($id);
            if ($questions) {
                $questions->fill($questionDetails['qsn'])->save();

                if($questionDetails['qsn']['ans_type']=='radio' || $questionDetails['qsn']['ans_type']=='checkbox' || $questionDetails['qsn']['ans_type']=='multiple_input' || $questionDetails['qsn']['ans_type']=='cond_radio' || $questionDetails['qsn']['ans_type']=='range'){

                foreach ($questionDetails['option'] as  $value) {
                   $value['qsn_id']=$id;
                   QuestionOptions::updateOrCreate(['id'=>isset($value['id'])?$value['id']:0],$value);
                }
            }else{
                foreach($questionOptions as $options){
                      $options->delete();
              }
            }
                session()->flash('success', 'Questions updated successfully!');

                return redirect(route('question.index'));
            } else {
                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $value = $this->questionRepository->findById($id);
            $getOptions = QuestionOptions::where('qsn_id',$id)->delete();
            $value->delete();
            session()->flash('success', 'Questions successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function deleteOption($id)
    {
        $id = (int)$id;
        try {
            $value = $this->questionOptionsRepository->findById($id);
            $value->delete();
            session()->flash('success', 'QuestionsOption successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }

    public function status($id){
        try {
            $id = (int)$id;
            $question = $this->questionRepository->findById($id);

            if ($question->qst_status == 'inactive') {
                $question->qst_status = 'active';
                $question->save();
                session()->flash('success', 'Questions has been Activated!');
                return back();
            } else {
                $question->qst_status = 'inactive';
                $question->save();
                session()->flash('success', 'Questions has been Deactivated!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    public function Questionnaire()
    {
        return view('backend.survey.questionnaire');
    }
}
