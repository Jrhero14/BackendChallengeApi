<?php

namespace App\Http\Services\Product;

use App\Exceptions\Debug;
use App\Exceptions\FailedResponse;
use App\Exceptions\UserNoFound;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\User\UserRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductServiceImplementation implements ProductService
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    public function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Untuk melakukan Upload gambar product ke server
     * @param Request $request
     * @return string => nama file gambar
     * @throws FailedResponse
     */
    public function uploadImage(Request $request)
    {
        try {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->storeAs('public', $imageName);
            return $imageName;
        } catch (\Exception $exception) {
            throw new FailedResponse($exception->getMessage(), 500);
        }
    }

    /**
     * Create New Product Service
     * @param array $validator
     * @param string $imageName
     * @return true
     * @throws FailedResponse
     */
    public function createNewProduct(array $validator, string $imageName)
    {
        $isUserExists = $this->userRepository->geById($validator["user_id"]);
        if (is_null($isUserExists)) {
            throw new FailedResponse("User by id = {$validator["user_id"]} not found", 404);
        }

        $validator["imageurl"] = $imageName;
        $validator["user_id"] = (int) $validator["user_id"];
        $validator["harga"] = (int) $validator["harga"];
        $validator["stok"] = (int) $validator["stok"];

        try {
            $this->productRepository->store($validator);
            return true;
        }catch (\Exception $e){
            throw new FailedResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws FailedResponse
     */
    public function getProductByUserId(int $id)
    {
        $getProduct = $this->productRepository->getByUserId($id);
        if (count($getProduct) == 0){
            throw new FailedResponse("Data by id user={$id} not found", 404);
        }
        return $getProduct;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws FailedResponse
     */
    public function getProductByProductId(int $id)
    {
        $getProduct = $this->productRepository->getByIdProduct($id);
        if (count($getProduct) == 0){
            throw new FailedResponse("Data by id={$id} not found", 404);
        }
        return $getProduct;
    }


    /**
     * @param Request $request
     * @param int $id
     * @param array $validator
     * @return mixed
     * @throws FailedResponse
     */
    public function updateDataProduct(Request $request, int $id, array $validator)
    {
        // Check is user exist
        $getProduct = $this->productRepository->getByIdProduct($id);
        if (count($getProduct) == 0){
            throw new FailedResponse("Data by id={$id} not found", 404);
        }

        // Check Image field are valid if exists in request
        if($request->exists('image')){
            $validImage = Validator::make(request()->all(), ['image' => 'required|image|mimes:jpeg,png,jpg']);
            if ($validImage->fails()) {
                throw new FailedResponse($validImage->errors(), 422);
            }
            $getProduct[0]->imageurl = $this->uploadImage($request);
        }

        // Add imageurl field into array
        $validator["imageurl"] = $getProduct[0]->imageurl;

        return $this->productRepository->update($id, $validator);
    }
}
