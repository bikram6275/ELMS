<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\Questionnaire;
use App\Repository\Configurations\QuestionnaireRepository;

class QuestionnaireController extends Controller
{
    protected $model;

    protected $questionnaireRepository;

    public function __construct(Questionnaire $model, QuestionnaireRepository $questionnaireRepository)
    {
        $this->model = $model;
        $this->questionnaireRepository = $questionnaireRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->questionnaireRepository->all();
        return view('backend.configurations.questionnaire.index',compact('rows'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,docx',
        ]);
        $file = new Questionnaire;

        if($request->file()) {
            $name = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/questionnaire', $name, 'public');

            $file->file_name = time().'_'.$request->file->getClientOriginalName();
            $file->path = '/storage/' . $filePath;
            $file->save();

            return back()
            ->with('success','File has uploaded to the database.')
            ->with('file', $name);
        }
        
        return back()
            ->with('success','You have successfully upload file.');

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id)
    {
        $questionnaire = $this->model->findOrFail($id);
        $pathToFile = public_path($questionnaire->path);
        return response()->download($pathToFile);

    }
}
