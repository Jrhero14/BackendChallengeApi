<?php

namespace App\Http\Repositories\Product;

use App\Exceptions\FailedResponse;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Validator;

class ProductRepositoryImplementation implements ProductRepository
{
    private Product $productModel;
    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * Get All Product
     * @param bool $withUser
     * @return Product[]|Builder[]|Collection
     */
    public function getAll(bool $withUser = false)
    {
        if ($withUser) {
            return $this->productModel->with('user')->get();
        }

        return $this->productModel->all();
    }

    public function store(array $data)
    {
        $this->productModel->create($data);
    }

    public function getByUserId(int $id)
    {
        return $this->productModel::query()->where('user_id', $id)->get();
    }

    public function getByIdProduct(int $id)
    {
        return $this->productModel::query()->where('id', '=', $id)->get();
    }

    public function update(int $id, array $data)
    {
        $updateData = $this->productModel::query()->where('id', $id);
        $updateData->update($data);
        return $updateData->get();
    }
}
