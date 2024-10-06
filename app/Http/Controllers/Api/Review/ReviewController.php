<?php

namespace App\Http\Controllers\Api\Review;

use App\Exceptions\Debug;
use App\Exceptions\FailedResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Review\ReviewService;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    private $reviewService;
    public function __construct(ReviewService  $reviewService)
    {
        $this->middleware('auth:api');
        $this->reviewService = $reviewService;
    }

    public function index(Request $request)
    {
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');
        return response()->json([
            'status' => true,
            'message' => 'Success get data reviews',
            'data' => $this->reviewService->getAllReviews($withUser, $withProduct),
        ], 200);
    }

    public function byIdReview(Request $request, $id){
        // Validate id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("Review id must be numeric", 400);
        }

        // Get Optional Params
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');

        // Process get data from service
        $data = $this->reviewService->getReview($id, $withUser, $withProduct);

        // Success Response
        return response()->json([
            'status' => true,
            'message' => 'Success get review data',
            'data' => $data
        ], 200);
    }

    public function byUserId(Request $request, $id){
        // Validate id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("Review id must be numeric", 400);
        }

        // Get Optional Params
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');

        // Process get data from service
        $data = $this->reviewService->getReviewByUserId($id, $withUser, $withProduct);

        return response()->json([
            'status' => true,
            'message' => 'Success get review',
            'data' => $data
        ], 200);
    }

    public function byProductId(Request $request, $id){
        // Validate id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("Review id must be numeric", 400);
        }

        // Get Optional Params
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');

        // Process get data from service
        $data = $this->reviewService->getReviewByProductId($id, $withUser, $withProduct);

        return response()->json([
            'status' => true,
            'message' => 'Success get review',
            'data' => $data
        ], 200);
    }

    public function searchReview(Request $request){
        // Validate request field
        $validData = Validator::make(request()->all(), [
            'rating' => 'numeric',
            'body' => 'string',
        ]);
        if ($validData->fails()) {
            throw new FailedResponse($validData->errors(), 422);
        }

        $validData = $validData->validate();

        // Get Optional Params
        $withUser = $request->get('withUser');
        $withProduct = $request->get('withProduct');

        // Success Response
        return response()->json([
            'status' => true,
            'message' => 'Success search review',
            'data' => $this->reviewService->searchReviews($validData, $withUser, $withProduct)
        ]);
    }

    public function createReview(Request $request){
        // Validate request field
        $validData = Validator::make(request()->all(), [
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'body' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        if ($validData->fails()) {
            throw new FailedResponse($validData->errors(), 422);
        }

        $validData = $validData->validate();

        // Success Response
        return response()->json([
            'status' => true,
            'message' => 'Success create review',
            'data' => $this->reviewService->createReview($validData)
        ], 201);
    }

    public function updateReview(Request $request, $id){
        // Validate id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("Review id must be numeric", 400);
        }

        // Validate field request
        $validData = Validator::make(request()->all(), [
            'body' => 'required',
            'rating' => 'required|numeric|min:1|max:5'
        ]);
        if ($validData->fails()) {
            throw new FailedResponse($validData->errors(), 422);
        }

        $validData = $validData->validate();

        return response()->json([
            'status' => true,
            'message' => 'Success update review',
            'data' => $this->reviewService->updateReview($id, $validData)
        ], 200);
    }

    public function deleteReview(Request $request, $id){
        // Validate id is numeric
        if (!is_numeric($id)){
            throw new FailedResponse("Review id must be numeric", 400);
        }

        // Delete Process in Service
        $this->reviewService->deleteReview($id);

        // Success Response
        return response()->json([
            'status' => true,
            'message' => 'Success delete review'
        ], 200);
    }
}
