<?php

namespace App\Http\Services\Product;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface ProductService
{
    public function uploadImage(Request $request);
    public function createNewProduct(array $validator, string $imageName);
    public function getProductByUserId(int $id);
    public function getProductByProductId(int $id);
    public function updateDataProduct(Request $request, int $id, array $validator);
}
