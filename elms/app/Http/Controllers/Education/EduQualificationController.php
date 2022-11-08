<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Education\EducationQualificationRepository;
use App\Repository\Qualification\QualificationRepository;
use App\Http\Requests\Education\EducationQualificationRequest;
use App\Models\Education\EducationQualification;
use App\Models\TechnicalHumanResources;

class EduQualificationController extends Controller
{
    /**
     * @var EducationQualificationRepository
     */
    private $educationrepository;
    /**
     * @var EducationQualification
     */
    private $educationqualification;
    /**
     * @var QualificationRepository
     */
    private $qualificationRepository;

    public function __construct(EducationQualificationRepository $educationrepository , EducationQualification $educationqualification,QualificationRepository $qualificationRepository)
    {

        $this->educationrepository = $educationrepository;
        $this->educationqualification = $educationqualification;
        $this->qualificationRepository = $qualificationRepository;
    }

    public function index()
    {
        $qualifications=$this->educationrepository->all();
        $educations = ['general' => 'General', 'tvet' => 'TVET'];
//        $educations=$this->qualificationRepository->all();
        return view('backend.education.index',compact('qualifications','educations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EducationQualificationRequest $request)
    {
        try {
            $value=$request->all();
            $value['type']=$request->type;
            $create = $this->educationqualification->create($request->all());
            if ($create) {
                session()->flash('success', 'Education Qualification Added Sucessfully!');
                return back();
            } else {
                session()->flash('error', 'could not be added!');
                return back();
            }

        } catch (\Exception $e) {
            $e = $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return back();
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
            $edits = $this->educationrepository->findById($id);
            if ($edits->count() > 0) {
                $qualifications=$this->educationrepository->all();
                $educations = ['general' => 'General', 'tvet' => 'TVET'];
                return view('backend.education.index', compact('qualifications', 'educations','edits'));
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
    public function update(EducationQualificationRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $qualification = $this->educationrepository->findById($id);
            if ($qualification) {
                $qualification->fill($request->all())->save();
                session()->flash('success', 'Education Qualification updated successfully!');

                return redirect(route('education_qualification.index'));
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
            $technical_data= TechnicalHumanResources::where('edu_qua_id',$id)->get();
            if(count($technical_data)>0){
                session()->flash('error', 'Cannot delete this item!');

            }else{
                $value = $this->educationrepository->findById($id);
                $value->delete();
                session()->flash('success', 'Education Qualification successfully deleted!');
            }
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
