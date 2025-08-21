<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends BaseController
{
    public function index (Request $request) 
    {
        $user = $request->user();

        $wishlists = Wishlist::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

        return $this->sendResponse(
            $wishlists,
            'Wishlists fetched successfully!!!.',
        );
    }

    public function show (Request $request, Wishlist $wishlist) 
    {
        $user = $request->user();

        $wishlist = Wishlist::with('user', 'product')
            ->where('user_id', $user->id)
            ->whereId($wishlist->id)
            ->first();

        return $this->sendResponse(
            $wishlist,
            'Wishlist fetched successfully!!!.',
        );
    }
}
