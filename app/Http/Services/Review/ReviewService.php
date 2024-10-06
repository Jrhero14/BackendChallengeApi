<?php

namespace App\Http\Services\Review;

use Illuminate\Http\Request;

interface ReviewService
{
    public function getAllReviews($withUser, $withProduct);
    public function getReview($id, $withUser, $withProduct);
    public function getReviewByUserId($id, $withUser, $withProduct);
    public function getReviewByProductId($id, $withUser, $withProduct);
    public function searchReviews($requestData, $withUser, $withProduct);
    public function createReview($validData);
    public function updateReview($id, $validData);
    public function deleteReview($id);
}
