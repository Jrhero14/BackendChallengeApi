<?php

namespace App\Http\Services\Product;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface ProductService
{
    public function uploadImage(Request $request);
    public function createNewProduct(Request $request, array $validator);
    public function getProductByUserId(int $id);
    public function getProductByProductId(int $id);
    public function updateDataProduct(Request $request, int $id, array $validator);
    public function deleteProduct(int $id);
    public function filterProduct(Request $request);
}
