<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseController
{
    public function index() 
    {
        return response()->json([
            'data' => Review::withCount('article')->get(),
        ]);
    }

    public function show(Review $review) {
        return response()->json([
            'data' => $review::with('article')->firstOrFail(),
        ]);
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
