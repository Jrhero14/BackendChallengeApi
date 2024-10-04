<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->withUserProduct($request);
        $data = $data->get();

        return response()->json([
            'status' => true,
            'message' => 'Success get all reviews',
            'data' => $data
        ], 200);
    }

    public function byIdReview(Request $request, $id){
        $data = $this->withUserProduct($request);
        $data = $data->where('id', $id)->get();

        if (count($data) == 0){
            return response()->json([
                'status' => false,
                'message' => "Review id = {$id} not found",
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get review',
            'data' => $data
        ], 200);
    }

    public function byUserId(Request $request, $id){
        $data = $this->withUserProduct($request);
        $data = $data->where('user_id', $id)->get();

        if (count($data) == 0){
            return response()->json([
                'status' => false,
                'message' => "Review by User id = {$id} not found",
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get review',
            'data' => $data
        ], 200);
    }

    public function byProductId(Request $request, $id){
        $data = $this->withUserProduct($request);
        $data = $data->where('product_id', $id)->get();

        if (count($data) == 0){
            return response()->json([
                'status' => false,
                'message' => "Review by Product id = {$id} not found",
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success get review',
            'data' => $data
        ], 200);
    }

    public function withUserProduct(Request $request): Builder
    {
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');

        $reviews = Review::query();

        if (filter_var($withUser, FILTER_VALIDATE_BOOLEAN)) {
            $reviews = $reviews->with('user');
        }

        if (filter_var($withProduct, FILTER_VALIDATE_BOOLEAN)) {
            $reviews = $reviews->with('product');
        }
        return $reviews;
    }

    public function searchReview(Request $request){
        $validData = Validator::make(request()->all(), [
            'rating' => 'numeric',
            'body' => 'string',
        ]);

        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validData->errors()
            ], 422);
        }

        $getRatingParam = $request->get('rating');
        $getBodyParam = $request->get('body');
        $review = Review::query();
        if ($getRatingParam){
            $review = $review->where('rating', (int) $getRatingParam);
        }

        if ($getBodyParam){
            $review = $review->where('body', 'like', '%'.$getBodyParam.'%');
        }
        $review = $review->get();

        return response()->json([
            'status' => true,
            'message' => 'Success search review',
            'data' => $review
        ]);
    }

    public function createReview(Request $request){
        $validData = Validator::make(request()->all(), [
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'body' => 'required',
            'rating' => 'required|numeric'
        ]);

        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validData->errors()
            ], 422);
        }

        $newReview = Review::create($validData->validate());
        return response()->json([
            'status' => true,
            'message' => 'Success create review',
            'data' => $newReview
        ], 201);
    }

    public function updateReview(Request $request, $id){
        $data = Review::query()->where('id', $id)->first();
        if (is_null($data)) {
            return response()->json([
                'status' => false,
                'message' => "Review id {$id} not found",
                'data' => []
            ], 404);
        }

        $validData = Validator::make(request()->all(), [
            'body' => 'required',
            'rating' => 'required|numeric'
        ]);

        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'test' => $data,
                'message' => $validData->errors()
            ], 422);
        }

        $data->rating = (int) $request->get('rating');
        $data->body = $request->get('body');
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Success update review',
            'data' => $data
        ], 200);
    }

    public function deleteReview(Request $request, $id){
        $data = Review::query()->where('id', $id)->first();
        if (is_null($data)) {
            return response()->json([
                'status' => false,
                'message' => "Review id {$id} not found",
                'data' => []
            ], 404);
        }
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Success delete review'
        ], 200);
    }
}
