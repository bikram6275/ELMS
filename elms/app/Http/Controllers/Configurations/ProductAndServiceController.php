<?php

namespace App\Http\Controllers\Configurations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configurations\ProductServiceRequest;
use App\Models\Configuration\ProductAndServices;
use App\Repository\Configurations\ProductAndServiceRepository;
use App\Repository\EconomicSector\EconomicSectorRepository;
use Illuminate\Http\Request;

class ProductAndServiceController extends Controller
{
    public function __construct(ProductAndServiceRepository $productRepository, EconomicSectorRepository $economicSectorRepository)
    {
        
        $this->productRepository = $productRepository;
        $this->economicSectorRepository = $economicSectorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = $this->productRepository->all();
            $sub_sectors = $this->economicSectorRepository->allSubSectors();
            return view('backend.configurations.productandservice.index',compact('products','sub_sectors'));
        } catch (\Throwable $th) {
            //throw $th;
        }
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
    public function store(ProductServiceRequest $request)
    {
        // return $request;
        try {
            foreach($request->product_and_services_name as $product)
            {
                 ProductAndServices::create([
                     'sub_sector_id' => $request->sub_sector_id,
                     'product_and_services_name'=>$product
                 ]);
            }
            session()->flash('success', 'Product added successfully!');
            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect()->back();
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
            $edits = $this->productRepository->findById($id);
            if ($edits->count() > 0) {
                $products = $this->productRepository->all();
                $sub_sectors=$this->economicSectorRepository->allSubSectors();
                return view('backend.configurations.productandservice.index', compact('edits','sub_sectors','products'));
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
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        try {
            $products = $this->productRepository->findById($id);
            if ($products) {
                $products->fill($request->all())->save();
                session()->flash('success', 'Products updated successfully!');

                return redirect(route('product_and_service.index'));
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
            $value = $this->productRepository->findById($id);
            $value->delete();
            session()->flash('success', 'Product and services successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    
    }
}
