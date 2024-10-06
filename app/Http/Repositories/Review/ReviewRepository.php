<?php

namespace App\Http\Repositories\Review;

interface ReviewRepository
{
    public function getAll($withUser, $withProduct);
    public function getByIdReview(int $id, $withUser, $withProduct);
    public function getByIdUser(int $id, $withUser, $withProduct);
    public function getByIdProduct(int $id, $withUser, $withProduct);
    public function filterReviews($withUser, $withProduct, array $queryList);
    public function createReview(array $data);
    public function updateReview(int $id, $data);
    public function delete(int $id);
}
