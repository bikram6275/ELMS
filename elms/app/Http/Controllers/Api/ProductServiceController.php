<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductServiceResoure;
use App\Repository\Configurations\ProductAndServiceRepository;
use Illuminate\Http\Request;

class ProductServiceController extends Controller
{
    public function __construct(ProductAndServiceRepository $productAndServiceRepository)
    {
        $this->productAndServiceRepository = $productAndServiceRepository;
    }
    public function index()
    {
        try {
            $products = $this->productAndServiceRepository->all();
            return response()->json(['data' => ProductServiceResoure::collection($products)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }
}
