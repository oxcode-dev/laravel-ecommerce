<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseController
{
    public function index(Request $request) 
    {
        $user = $request->user();

        $cacheKey = 'reviews_' . $request->get('search', '') . '_page_' . $request->get('perPage', 10);

        $reviews = Cache::remember($cacheKey, now()->addMinutes(1), fn () => Review::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10))
        );

        return $this->sendResponse(
            $reviews,
            'Reviews fetched successfully!!!.',
        );
    }

    public function show(Request $request, Review $review) {
        $user = $request->user();

        $review = Review::with('user', 'product')
            ->where('user_id', $user->id)
            ->whereId($review->id)
            ->first();

        return $this->sendResponse(
            $review,
            'Review fetched successfully!!!.',
        );
    }

    public function store(Request $request) 
    {
        $user =  $request->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'comment' => 'required',
            'rating' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(Review::where('product_id', $request->product_id)->where('user_id', $user->id)->exists()) {
            return $this->sendError(
                'Review Exist Error.',
                'Review Already Made!!!'
            );       
        }

        $review = new Review();

        $review->product_id = $request->product_id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->user_id = $user->id;

        $review->save();

        Cache::flush();
        
        return $this->sendResponse(
            'Product Review saved successfully.',
            'Product Review Saved!!!.',
        );
    }

    public function destroy(Request $request, Review $review) 
    {
        Review::find($review->id)?->delete();
        
        return $this->sendResponse(
            'Product Review deleted successfully.',
            'Product Review Deleted!!!.',
        );
    }
}
