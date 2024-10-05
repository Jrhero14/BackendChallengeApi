<?php

namespace App\Http\Repositories\Product;

use Illuminate\Validation\Validator;

interface ProductRepository
{
    public function getAll(bool $withUser = false);
    public function store(array $data);
    public function update(int $id, array $data);
    public function getByUserId(int $id);
    public function getByIdProduct(int $id);
}
