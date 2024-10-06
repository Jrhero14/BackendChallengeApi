<?php

namespace App\Http\Services\Review;

use App\Exceptions\FailedResponse;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Review\ReviewRepository;
use App\Http\Repositories\User\UserRepository;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewServiceImplementation implements ReviewService
{
    private $reviewRepository;
    private $productRepository;
    private $userRepository;
    public function __construct(ReviewRepository $reviewRepository, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllReviews($withUser, $withProduct)
    {
        return $this->reviewRepository->getAll($withUser, $withProduct);
    }

    public function getReview($id, $withUser, $withProduct){
        $data = $this->reviewRepository->getByIdReview($id, $withUser, $withProduct);
        if (count($data) == 0){
            throw new FailedResponse("Review id = {$id} not found", 404);
        }
        return $data;
    }

    public function getReviewByUserId($id, $withUser, $withProduct)
    {
        $data = $this->reviewRepository->getByIdUser($id, $withUser, $withProduct);
        if (count($data) == 0){
            throw new FailedResponse("Review by User id = {$id} not found", 404);
        }
        return $data;
    }

    public function getReviewByProductId($id, $withUser, $withProduct)
    {
        $data = $this->reviewRepository->getByIdProduct($id, $withUser, $withProduct);
        if (count($data) == 0){
            throw new FailedResponse("Review by Product id = {$id} not found", 404);
        }
        return $data;
    }

    public function searchReviews($searchField, $withUser, $withProduct)
    {
        $queryList = [];
        if (array_key_exists('rating', $searchField)){
            $queryList[] = ['rating', '=', (int)$searchField['rating']];
        }
        if (array_key_exists('body', $searchField)){
            $queryList[] = ['body', 'like', '%'.$searchField['body'].'%'];
        }
        $data = $this->reviewRepository->filterReviews($withUser, $withProduct, $queryList);
        if (count($data) == 0){
            throw new FailedResponse("Data not found", 404);
        }
        return $data;
    }

    public function createReview($validData)
    {
        $user = $this->userRepository->geById($validData["user_id"]);
        if (!$user){
            throw new FailedResponse("User with id={$validData['user_id']} not found", 404);
        }
        $product = $this->productRepository->getByIdProduct($validData["product_id"]);
        if (!$product){
            throw new FailedResponse("Product with id={$validData['product_id']} not found", 404);
        }
        return $this->reviewRepository->createReview($validData);
    }

    public function updateReview($id, $validData)
    {
        $data = $this->reviewRepository->getByIdReview($id, false, false);
        if (count($data) == 0) {
            throw new FailedResponse("Review id {$id} not found", 404);
        }
        return $this->reviewRepository->updateReview($id, $validData);
    }

    public function deleteReview($id)
    {
        $data = $this->reviewRepository->getByIdReview($id, false, false);
        if (count($data) == 0) {
            throw new FailedResponse("Review id {$id} not found", 404);
        }
        return $this->reviewRepository->delete($id);
    }
}
