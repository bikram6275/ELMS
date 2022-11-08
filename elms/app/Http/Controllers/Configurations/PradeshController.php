<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\Pradesh;
use App\Models\Configuration\District;
use App\Http\Requests\Configurations\PradeshRequest;
use App\Repository\Configurations\PradeshRepository;

class PradeshController extends Controller
{

    /**
     * @var PradeshRepository
     */
    private $pradeshRepository;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PradeshRepository $pradeshRepository)
    {
        
        $this->pradeshRepository = $pradeshRepository;
    }

    public function index()
    {
        $pradeshs = $this->pradeshRepository->all();
        return view('backend.configurations.pradesh.index', compact('pradeshs'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PradeshRequest $request)
    {
        try {
            $create = Pradesh::create($request->all());
            if ($create) {
                session()->flash('success', 'Pradesh successfully created!');
                return back();
            } else {
                session()->flash('error', 'Pradesh could not be created!');
                return back();
            }
        } catch (\Exception $e) {
            $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->pradeshRepository->findById($id);
            if ($edits->count() > 0) {
                $pradeshs = $this->pradeshRepository->all();
                return view('backend.configurations.pradesh.index', compact('edits', 'pradeshs'));
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PradeshRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $pradesh = $this->pradeshRepository->findById($id);
            if ($pradesh) {
                $pradesh->fill($request->all())->save();
                session()->flash('success', 'Pradesh updated successfully!');

                return redirect(route('pradesh.index'));
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $value = $this->pradeshRepository->findById($id);
            if ($value) {
                $valueId = $value->id;
                $result = District::where('pradesh_id', $valueId)->get();

                if (count($result) > 0) {
                    session()->flash('error', 'Pradesh is in use. Unable to delete!');
                    return back();
                }

                $value->delete();
                session()->flash('success', 'Pradesh successfully deleted!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
