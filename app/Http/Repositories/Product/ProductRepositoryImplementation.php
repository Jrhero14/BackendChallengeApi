<?php

namespace App\Http\Repositories\Product;

use App\Exceptions\Debug;
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

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->productModel->create($data);
    }

    /**
     * @param int $id
     * @return Builder[]|Collection
     */
    public function getByUserId(int $id)
    {
        return $this->productModel::query()->where('user_id', $id)->get();
    }

    /**
     * @param int $id
     * @return Builder[]|Collection
     */
    public function getByIdProduct(int $id)
    {
        return $this->productModel::query()->where('id', '=', $id)->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return Builder[]|Collection
     */
    public function update(int $id, array $data)
    {
        $updateData = $this->productModel::query()->where('id', $id);
        $updateData->update($data);
        return $updateData->get();
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function delete(int $id)
    {
        return $this->productModel::query()->find( $id)->delete();
    }

    /**
     * @param array $queryRequest
     * @return Builder[]|Collection
     */
    public function filter(array $queryRequest)
    {
        $queryBuiler = $this->productModel::query();
        foreach ($queryRequest as $query) {
            if (!is_null($query[2])){
                if ($query[1] == 'like'){
                    $queryBuiler = $queryBuiler->where($query[0], $query[1], '%'.$query[2].'%');
                } else {
                    $queryBuiler = $queryBuiler->where($query[0], $query[1], $query[2]);
                }
            }
        }
        return $queryBuiler->get();
    }
}
