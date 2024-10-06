<?php

namespace App\Http\Repositories\Review;

use App\Exceptions\Debug;
use App\Exceptions\FailedResponse;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReviewRepositoryImplementation implements ReviewRepository
{
    private $reviewModel;
    public function __construct(Review $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    private function withUserOrProduct(Builder $queryPrev, $withUser, $withProduct): void
    {
        if (filter_var($withUser, FILTER_VALIDATE_BOOLEAN)) {
            $queryPrev->with('user');
        }
        if (filter_var($withProduct, FILTER_VALIDATE_BOOLEAN)) {
            $queryPrev->with('product');
        }
    }

    public function getAll($withUser, $withProduct)
    {
        $query = $this->reviewModel::query();
        $this->withUserOrProduct($query, $withUser, $withProduct);
        return $query->get();
    }

    public function getByIdReview(int $id, $withUser, $withProduct)
    {
        $query = $this->reviewModel::query();
        $this->withUserOrProduct($query, $withUser, $withProduct);
        return $query->where('id', $id)->get();
    }

    public function getByIdUser(int $id, $withUser, $withProduct)
    {
        $query = $this->reviewModel::query();
        $this->withUserOrProduct($query, $withUser, $withProduct);
        return $query->where('user_id', $id)->get();
    }

    public function getByIdProduct(int $id, $withUser, $withProduct)
    {
        $query = $this->reviewModel::query();
        $this->withUserOrProduct($query, $withUser, $withProduct);
        return $query->where('product_id', $id)->get();
    }

    public function filterReviews($withUser, $withProduct, array $queryList)
    {
        $query = $this->reviewModel::query();
        $this->withUserOrProduct($query, $withUser, $withProduct);
        foreach ($queryList as $querydata) {
            $query->where($querydata[0], $querydata[1], $querydata[2]);
        }
        return $query->get();
    }

    public function createReview(array $data)
    {
        return $this->reviewModel::query()->create($data);
    }

    public function updateReview(int $id, $data)
    {
        $review = $this->reviewModel::query()->where('id', $id)->first();
        $review->rating = (int) $data['rating'];
        $review->body = $data['body'];
        if (!$review->save()){
            throw new FailedResponse("Error cannot update review data", 500);
        }
        return $review;
    }

    public function delete(int $id)
    {
        $isDelete = $this->reviewModel::query()->where('id', $id)->delete();
        if (!$isDelete){
            throw new FailedResponse("Error cannot delete review data", 500);
        }
        return true;
    }
}
