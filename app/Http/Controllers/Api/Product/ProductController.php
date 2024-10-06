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
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(request $request)
    {
        $withUser = $request->get('withuser');
        $products = $this->productService->getAllProducts($withUser);
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $products
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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

        // Store Product in Service
        $productCreated = $this->productService->createNewProduct($request, $validateData->validate());

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success save product data',
            'data' => $productCreated
        ], 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     */
    public function showByIdUser($id)
    {
        // Check if id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $this->productService->getProductByUserId($id)
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     */
    public function showByIdProduct(Request $request, $id)
    {
        // Check if id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }

        // Get option params
        $isWithReviews = $request->get('withReviews');

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $this->productService->getProductByProductId($id, $isWithReviews)
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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

        // Check Image field are valid if exists in request
        if($request->exists('image')){
            $validImage = Validator::make(request()->all(), ['image' => 'required|image|mimes:jpeg,png,jpg']);
            if ($validImage->fails()) {
                throw new FailedResponse($validImage->errors(), 422);
            }
        }

        // Update Process in service container
        $getProduct = $this->productService->updateDataProduct($request, $id, $validateData->validate());

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success update product data',
            'data' => $getProduct
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     */
    public function destroy($id)
    {
        // Validation id is number
        if (!is_numeric($id)){
            throw new FailedResponse("id params must Integer\number", 400);
        }

        // Process Delete and Check is success or not
        if (!$this->productService->deleteProduct($id)){
            throw new FailedResponse("Failed to delete product data", 500);
        }

        // Success Response
        return response()->json([
            'status' => true,
            'message' => 'Success delete product data',
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     */
    public function searchProduct(Request $request)
    {
        // Validation data request
        $validData = Validator::make(request()->all(), [
            'start_harga' => 'numeric',
            'end_harga' => 'numeric',
            'start_stok' => 'numeric',
            'end_stok' => 'numeric',
        ]);
        if ($validData->fails()) {
            throw new FailedResponse($validData->errors(), 422);
        }

        // Response Success
        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $this->productService->filterProduct($request)
        ], 200);
    }
}
