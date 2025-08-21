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

        $reviews = Review::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

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
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'product_id' => 'required',
            'content' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user =  $request->user();

        $review = new Review();

        $review->parent_id = $request->parent_id;
        $review->article_id = $request->article_id;
        $review->content = $request->content;
        $review->user_id = $user->name;

        $review->save();
        
        return $this->sendResponse(
            'Article comment saved successfully.',
            'Article Comment Saved!!!.',
        );
    }

    public function destroy(Request $request, Review $review) 
    {
        Review::find($review->id)?->delete();
        
        return $this->sendResponse(
            'Article comment deleted successfully.',
            'Article Comment Deleted!!!.',
        );
    }
}
