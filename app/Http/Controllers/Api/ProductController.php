<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Get All Product Data
    public function index(request $request)
    {
        $withUser = $request->get('withuser');
        if(filter_var($withUser, FILTER_VALIDATE_BOOLEAN)){
            $products = Product::with('user')->get();
        }
        else{
            $products = Product::all();
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $products
        ], 200);
    }

    // Create New Product
    public function create(Request $request)
    {
        $validateData = Validator::make(request()->all(), [
            'user_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validateData->errors()
            ], 422);
        }

        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->storeAs('images', $imageName);

        $newProduct = new Product();
        $newProduct->user_id = (int) $request->get('user_id');
        $newProduct->nama = $request->get('nama');
        $newProduct->imageurl = $imageName;
        $newProduct->deskripsi = $request->get('deskripsi');
        $newProduct->harga = (int) $request->get('harga');
        $newProduct->stok = (int) $request->get('stok');
        try {
            $newProduct->save();
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success save product data',
            'data' => $newProduct
        ], 201);
    }

    // Get Product by ID User
    public function showByIdUser($id)
    {
        $getProduct = Product::query()->where('user_id', $id)->get();

        if (!$getProduct){
            return response()->json([
                'status' => false,
                'message' => "Data by id user ={$id} not found",
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'test' => $id,
            'message' => 'Success get product data',
            'data' => $getProduct
        ], 200);
    }

    // Get Product By ID Product
    public function showByIdProduct($id)
    {
        $getProduct = Product::where('id', '=', $id)->first();

        if (!$getProduct){
            return response()->json([
                'status' => false,
                'message' => "Data by id={$id} not found",
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get product data',
            'data' => $getProduct
        ], 200);
    }

    public function updateData(Request $request, $id)
    {
        $getProduct = Product::query()->where('id', $id)->first();
        if (!$getProduct){
            return response()->json([
                'status' => false,
                'message' => "Data Product by id={$id} not found",
                'data' => []
            ], 404);
        }

        $validateData = Validator::make(request()->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validateData->errors()
            ], 422);
        }

        $getProduct->nama = $request->get('nama');
        if($request->exists('image')){
            $validImage = Validator::make(request()->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg'
            ]);
            if ($validImage->fails()) {
                return response()->json([
                    'status' => false,
                    'messsage' => $validImage->errors()
                ], 422);
            }
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->storeAs('images', $imageName);
            $getProduct->imageurl = $imageName;
        }
        $getProduct->deskripsi = $request->get('deskripsi');
        $getProduct->harga = (int) $request->get('harga');
        $getProduct->stok = (int) $request->get('stok');
        try {
            $getProduct->save();
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

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
