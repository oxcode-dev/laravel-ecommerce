<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends BaseController
{
    public function index (Request $request) 
    {
        $cacheKey = 'products_api_' . $request->get('page', 1) . '_limit_' . $request->get('perPage', 20);
        
        $products = Cache::remember($cacheKey, now()->addMinutes(1), fn () => Product::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 20)));

        return $this->sendResponse(
            $products,
            'Products fetched successfully!!!.',
        );
    }

    public function show(Request $request, $slug)//: Response
    {
        $product = Product::where('slug', $slug)
            ->with('category', 'user', 'reviews.user', 'wishlists')
            ->where('is_active', true)->first();

        return $this->sendResponse(
            $product,
            'Product fetched successfully!!!.',
        );
    }

    public function cartProducts(Request $request)
    {
        $ids = $request->get('id');

        $products = Product::whereIn('id', $ids)->get();

        return $this->sendResponse(
            $products,
            'Products fetched successfully!!!.',
        );
    }
}
