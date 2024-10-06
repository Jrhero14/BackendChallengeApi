<?php

namespace App\Http\Repositories\Product;

use Illuminate\Validation\Validator;

interface ProductRepository
{
    public function getAll(bool $withUser = false);
    public function getByUserId(int $id);
    public function getByIdProduct(int $id, bool $withReviews = false);
    public function store(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function filter(array $queryRequest);
}
