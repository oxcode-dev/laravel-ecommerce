<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Resources\WishlistResource;
use App\Http\Resources\WishlistCollection;
use Illuminate\Support\Facades\Cache;

class WishlistController extends BaseController
{
    public function index (Request $request) 
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $cacheKey = 'user_wishlists_search_' . $request->get('search', '') . '_page_' . $request->get('perPage', 15);

        $wishlists = Cache::remember($cacheKey, now()->addMinutes(1), fn () => Wishlist::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 15))
        );

        return $this->sendResponse(
            // WishlistResource::collection($wishlists),
            $wishlists,
            'Wishlists fetched successfully!!!.',
        );
    }

    public function show (Request $request, Wishlist $wishlist) 
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $wishlist = Wishlist::with('user', 'product')
            ->where('user_id', $user->id)
            ->whereId($wishlist->id)
            ->first();

        return $this->sendResponse(
            $wishlist,
            'Wishlist fetched successfully!!!.',
        );
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $product_id = $request->get('product_id');

        if(!Wishlist::where('user_id', $user->id)->where('product_id', $product_id)->exists()) {
            $wishlist = Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product_id
            ]);

            return $this->sendResponse(
                $wishlist,
                'Wishlist Added successfully!!!.',
            );
        }

        Wishlist::where('user_id', $user->id)->where('product_id', $product_id)->delete();

        Cache::flush();

        return $this->sendResponse(
            'Wishlist Removed.',
            'Wishlist Removed successfully!!!.',
        );
    }

    public function destroy(Request $request, Wishlist $wishlist)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        Wishlist::where('user_id', $user->id)->whereId($wishlist->id)->delete();

        Cache::flush();

        return $this->sendResponse(
            'Wishlist Removed.',
            'Wishlist Removed successfully!!!.',
        );
    }
}
