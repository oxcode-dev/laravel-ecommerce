<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index (Request $request) 
    {
        $products = Product::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

        return $this->sendResponse(
            $products,
            'Products fetched successfully!!!.',
        );
    }

    public function show(Request $request, Product $product)//: Response
    {
        $product = $product::with('category', 'user', 'reviews.user')
            ->whereId($product->id)->where('is_active', true)->first();

        return $this->sendResponse(
            $product,
            'Product fetched successfully!!!.',
        );
    }
}
