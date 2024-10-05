<?php

namespace App\Http\Controllers\Api\Product;

use App\Exceptions\Debug;
use App\Exceptions\FailedResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Services\Product\ProductService;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;
    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->middleware('auth:api');
    }

    public function index(request $request)
    {
        $withUser = $request->get('withuser');
        $products = $this->productRepository->getAll(filter_var($withUser, FILTER_VALIDATE_BOOLEAN));
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $products
        ], 200);
    }

    public function create(Request $request)
    {
        // Check validate data request
        $validateData = Validator::make(request()->all(), [
            'user_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        if ($validateData->fails()) {
            throw new FailedResponse($validateData->errors(), 422);
        }

        // Upload Image Process
        $imageName = $this->productService->uploadImage($request);
        if (!$imageName) {
            throw new FailedResponse("Failed upload image, problem in server", 500);
        }

        // Store Product in Service
        $isCreated = $this->productService->createNewProduct(
            $validateData->validate(),
            $imageName,
        );

        // Check is Product failed create
        if (!$isCreated) {
            throw new FailedResponse("Failed to create new product, problem in server", 500);
        }

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success save product data',
            'data' => $isCreated
        ], 201);
    }

    public function showByIdUser($id)
    {
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $this->productService->getProductByUserId($id)
        ], 200);
    }

    public function showByIdProduct($id)
    {
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $this->productService->getProductByProductId($id)
        ], 200);
    }

    public function updateData(Request $request, $id)
    {
        // Validation id is number
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }

        // Validation field request
        $validateData = Validator::make(request()->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        if ($validateData->fails()) {
            throw new FailedResponse($validateData->errors(), 422);
        }

        // Update Process in service container
        $getProduct = $this->productService->updateDataProduct($request, $id, $validateData->validate());

        // Response update product is successfully
        return response()->json([
            'status' => true,
            'message' => 'Success update product data',
            'data' => $getProduct
        ], 200);
    }

    public function destroy($id)
    {
        $getProduct = Product::query()->where('id', $id)->first();
        if (!$getProduct){
            return response()->json([
                'status' => false,
                'message' => "Data by id={$id} not found",
            ], 404);
        }

        $getProduct->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success delete product data',
        ], 200);
    }

    public function searchProduct(Request $request)
    {
        $validData = Validator::make(request()->all(), [
            'start_harga' => 'numeric',
            'end_harga' => 'numeric',
            'start_stok' => 'numeric',
            'end_stok' => 'numeric',
        ]);

        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validData->errors()
            ], 422);
        }

        $getNamaParam = $request->get('nama');
        $getDeskripsiParam = $request->get('deskripsi');
        $getStartHargaParam = $request->get('start_harga');
        $getEndHargaParam = $request->get('end_harga');
        $getStartStokParam = $request->get('start_stok');
        $getEndStokParam = $request->get('end_stok');

        $getProduct = Product::query();
        if ($getNamaParam){
            $getProduct = $getProduct->where('nama', 'like', '%' . $getNamaParam . '%');
        }

        if ($getDeskripsiParam){
            $getProduct = $getProduct->where('deskripsi', 'like', '%' . $getDeskripsiParam . '%');
        }

        if ($getStartHargaParam){
            $getProduct = $getProduct->where('harga', '>=', (int) $getStartHargaParam);
        }

        if ($getEndHargaParam){
            $getProduct = $getProduct->where('harga', '<=', (int) $getEndHargaParam);
        }

        if ($getStartStokParam){
            $getProduct = $getProduct->where('stok', '>=', (int) $getStartStokParam);
        }

        if ($getEndStokParam){
            $getProduct = $getProduct->where('stok', '<=', (int) $getEndStokParam);
        }

        $getProduct = $getProduct->get();

        if (count($getProduct) == 0){
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $getProduct
        ], 200);
    }
}
